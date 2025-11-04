# writable/python/run_analysis_nb.py

import pandas as pd
import mysql.connector
import json
import sys

# --- PERBAIKAN UNTUK MENGHILANGKAN USERWARNING ---
import warnings
# Kita bungkam 'UserWarning' secara spesifik, yang berasal dari pd.read_sql
warnings.filterwarnings("ignore", category=UserWarning)
# ----------------------------------------------

from sklearn.model_selection import train_test_split
from sklearn.preprocessing import OrdinalEncoder, MinMaxScaler, LabelEncoder
from sklearn.naive_bayes import GaussianNB
from sklearn.metrics import accuracy_score, confusion_matrix, classification_report
from sklearn.compose import ColumnTransformer

def run_analysis():
    try:
        # --- 1. KONEKSI DATABASE (Menerima argumen dari PHP) ---
        if len(sys.argv) != 5:
            raise Exception("Skrip Python mengharapkan 4 argumen: host, user, password, database.")

        db_host = sys.argv[1]
        db_user = sys.argv[2]
        db_pass = sys.argv[3]
        db_name = sys.argv[4]

        if db_name != 'produk_db':
             raise Exception(f"Nama database salah. Diterima: '{db_name}', Diharapkan: 'produk_db'")

        db = mysql.connector.connect(
            host=db_host,
            user=db_user,
            password=db_pass,
            database=db_name
        )

        # --- 2. AMBIL DATA ---
        df = pd.read_sql("SELECT * FROM dataset_produk", db)
        db.close()

        if df.empty:
            raise Exception("Tabel 'dataset_produk' kosong.")

        # --- 3. PREPROCESSING & FEATURE ENGINEERING ---
        df['waktu_penjualan'] = pd.to_datetime(df['waktu_penjualan'])
        df['bulan'] = df['waktu_penjualan'].dt.month
        df['tahun'] = df['waktu_penjualan'].dt.year

        target_column = 'terjadi_penurunan'
        
        X = df.drop(columns=[target_column, 'id', 'created_at', 'updated_at', 'waktu_penjualan'])
        y_raw = df[target_column]

        le = LabelEncoder()
        y = le.fit_transform(y_raw)
        # y_classes_[0] adalah 'Tidak', y_classes_[1] adalah 'Ya'
        y_classes_ = le.classes_ 
        
        categorical_features = ['nama_produk', 'kategori_produk', 'status_promosi']
        numerical_features = ['harga_produk_rp', 'jumlah_terjual_unit']
        passthrough_features = ['bulan', 'tahun'] # Fitur yang hanya dilewatkan
        
        preprocessor = ColumnTransformer(
            transformers=[
                ('cat', OrdinalEncoder(handle_unknown='use_encoded_value', unknown_value=-1), categorical_features),
                ('num', MinMaxScaler(), numerical_features) # Scaling harga & jumlah
            ],
            remainder='passthrough' # 'bulan' dan 'tahun' akan lolos
        )

        # --- 4. TRAIN-TEST SPLIT ---
        X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

        # --- 5. TERAPKAN PREPROCESSING ---
        X_train_processed = preprocessor.fit_transform(X_train)
        X_test_processed = preprocessor.transform(X_test)
        
        # --- 6. TRAINING MODEL GAUSSIAN NAIVE BAYES ---
        model = GaussianNB()
        model.fit(X_train_processed, y_train)
        
        # --- 7A. EVALUASI MODEL ---
        y_pred = model.predict(X_test_processed)
        y_pred_labels = le.inverse_transform(y_pred)
        y_test_labels = le.inverse_transform(y_test)
        accuracy = accuracy_score(y_test, y_pred)
        cm = confusion_matrix(y_test_labels, y_pred_labels, labels=['Tidak', 'Ya'])
        
        if cm.shape == (1, 1):
            if y_test_labels[0] == 'Tidak': tn, fp, fn, tp = cm[0][0], 0, 0, 0
            else: tn, fp, fn, tp = 0, 0, 0, cm[0][0]
        else:
             tn, fp, fn, tp = cm.ravel()

        report = classification_report(y_test_labels, y_pred_labels, target_names=['Tidak', 'Ya'], output_dict=True, zero_division=0)
        
        # --- 7B. ANALISIS MODEL (BARU!) ---
        # Ekstrak 'otak' model (rata-rata dari setiap fitur)
        
        # model.theta_[0] adalah rata-rata fitur untuk kelas 'Tidak'
        # model.theta_[1] adalah rata-rata fitur untuk kelas 'Ya'
        
        # Dapatkan nama fitur sesuai urutan setelah di-transform
        # Contoh: ['cat__nama_produk', 'cat__kategori_produk', ..., 'num__harga_produk_rp', ..., 'remainder__bulan']
        feature_names_processed = preprocessor.get_feature_names_out()
        
        analysis_results = []
        for i, feature_name in enumerate(feature_names_processed):
            # Kita hanya tertarik pada fitur numerik asli dan fitur baru (bulan/tahun)
            # Kita abaikan fitur kategori yang sudah di-encode (cat__)
            
            # Bersihkan nama fitur
            if 'num__' in feature_name:
                display_name = feature_name.replace('num__', '')
            elif 'remainder__' in feature_name:
                display_name = feature_name.replace('remainder__', '')
            else:
                continue # Abaikan fitur 'cat__' karena sulit diinterpretasi

            # Ambil nilai rata-rata (mean) dari model
            mean_tidak_turun = model.theta_[0][i]
            mean_ya_turun = model.theta_[1][i]

            # Invers scaling jika fitur numerik (MinMaxScaler)
            # Ini penting agar kita melihat 'harga' dalam Rupiah, bukan 0-1
            if 'num__' in feature_name:
                # Temukan scaler yang sesuai dari preprocessor
                scaler = preprocessor.named_transformers_['num']
                feature_index_in_scaler = numerical_features.index(display_name)
                
                # Buat array dummy untuk inverse_transform
                # [0, 0, ..., mean_value, ..., 0, 0]
                mean_tidak_scaled = [0] * len(numerical_features)
                mean_ya_scaled = [0] * len(numerical_features)
                
                mean_tidak_scaled[feature_index_in_scaler] = mean_tidak_turun
                mean_ya_scaled[feature_index_in_scaler] = mean_ya_turun
                
                # Inverse transform
                original_mean_tidak = scaler.inverse_transform([mean_tidak_scaled])[0][feature_index_in_scaler]
                original_mean_ya = scaler.inverse_transform([mean_ya_scaled])[0][feature_index_in_scaler]
            else:
                # Fitur 'passthrough' (bulan, tahun) tidak perlu di-inverse
                original_mean_tidak = mean_tidak_turun
                original_mean_ya = mean_ya_turun

            analysis_results.append({
                "fitur": display_name,
                "rata_rata_tidak_turun": original_mean_tidak,
                "rata_rata_ya_turun": original_mean_ya
            })
        

        # --- 8. FORMAT HASIL SEBAGAI JSON ---
        results = {
            "status": "success",
            "evaluasi": { # Hasil lama sekarang ada di dalam 'evaluasi'
                "total_data": len(df),
                "total_training": len(X_train),
                "total_testing": len(X_test),
                "accuracy": accuracy * 100,
                "confusion_matrix": {
                    "true_negative": int(tn), "false_positive": int(fp),
                    "false_negative": int(fn), "true_positive": int(tp)
                },
                "classification_report": report
            },
            "analisis": analysis_results # <-- HASIL BARU!
        }
        
        print(json.dumps(results, indent=4))

    except Exception as e:
        error_result = {
            "status": "error",
            "message": str(e)
        }
        print(json.dumps(error_result, indent=4))
        sys.exit(1)

if __name__ == "__main__":
    run_analysis()