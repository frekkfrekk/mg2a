import mysql.connector
from flask import Flask, render_template, request, redirect, url_for, flash
from flask_login import LoginManager, UserMixin, login_user, login_required, logout_user
from werkzeug.security import generate_password_hash, check_password_hash
import os

app = Flask(__name__)
app.secret_key = "secret_key"
UPLOAD_FOLDER = 'static/uploads'
os.makedirs(UPLOAD_FOLDER, exist_ok=True)

login_manager = LoginManager()
login_manager.init_app(app)

# ----------------- Connexion MySQL -----------------
def get_db_connection():
    return mysql.connector.connect(
        host="localhost",
        user="ton_utilisateur",
        password="ton_motdepasse",
        database="nom_de_ta_base"
    )

# ----------------- Gestion Utilisateur -----------------
class User(UserMixin):
    def __init__(self, id, username, password):
        self.id = id
        self.username = username
        self.password = password

@login_manager.user_loader
def load_user(user_id):
    conn = get_db_connection()
    cursor = conn.cursor()
    cursor.execute("SELECT id, username, password FROM users WHERE id=%s", (user_id,))
    user = cursor.fetchone()
    conn.close()
    if user:
        return User(user[0], user[1], user[2])
    return None
@app.route('/')
def index():
    conn = get_db_connection()
    cursor = conn.cursor()
    cursor.execute("SELECT id, type, title, file_path FROM contents")
    contents = cursor.fetchall()
    conn.close()
    return render_template("index.html", contents=contents)

@app.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == "POST":
        username = request.form['username']
        password = request.form['password']

        conn = get_db_connection()
        cursor = conn.cursor()
        cursor.execute("SELECT id, username, password FROM users WHERE username=%s", (username,))
        user = cursor.fetchone()
        conn.close()

        if user and check_password_hash(user[2], password):
            user_obj = User(user[0], user[1], user[2])
            login_user(user_obj)
            return redirect(url_for('admin'))
        else:
            flash("Nom d'utilisateur ou mot de passe incorrect")
    return render_template("login.html")

@app.route('/admin', methods=['GET', 'POST'])
@login_required
def admin():
    if request.method == "POST":
        type_content = request.form['type']
        title = request.form['title']
        file = request.files['file']
        file_path = os.path.join(UPLOAD_FOLDER, file.filename)
        file.save(file_path)

        conn = get_db_connection()
        cursor = conn.cursor()
        cursor.execute(
            "INSERT INTO contents (type, title, file_path) VALUES (%s, %s, %s)",
            (type_content, title, file_path)
        )
        conn.commit()
        conn.close()
        flash("Contenu ajouté avec succès !")
        return redirect(url_for('admin'))

    conn = get_db_connection()
    cursor = conn.cursor()
    cursor.execute("SELECT id, type, title, file_path FROM contents")
    contents = cursor.fetchall()
    conn.close()
    return render_template("admin.html", contents=contents)

@app.route('/logout')
@login_required
def logout():
    logout_user()
    return redirect(url_for('login'))

if __name__ == "__main__":
    app.run(debug=True)
