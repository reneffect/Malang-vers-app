using System;
using System.Data.SqlClient;
using System.Windows.Forms;

namespace dekstop
{
    public partial class LoginForm : Form
    {
        public LoginForm()
        {
            InitializeComponent();
        }

        private void ShowPassword_CheckedChanged(object sender, EventArgs e)
        {
            passwordBox.UseSystemPasswordChar = !showPassword.Checked;
        }

        private void LoginButton_Click(object sender, EventArgs e)
        {
            SignIn();
        }

        private void SignIn()
        {
            string username = usernameBox.Text.Trim();
            string password = passwordBox.Text;

            if (string.IsNullOrWhiteSpace(username) || string.IsNullOrWhiteSpace(password))
            {
                MessageBox.Show("Username dan password harus diisi.", "Login",
                    MessageBoxButtons.OK, MessageBoxIcon.Warning);
                return;
            }

            try
            {
                loginButton.Enabled = false;
                UserModel user = DatabaseService.AuthenticateUser(username, password);
                if (user == null)
                {
                    MessageBox.Show("Username atau password salah, atau akun tidak ditemukan di database.",
                        "Login Gagal", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    return;
                }

                UserSession.UserId = user.UserId;
                UserSession.Nama = user.UserNama;
                UserSession.Username = user.UserUsername;
                UserSession.Role = user.UserRole;

                Hide();
                if (string.Equals(user.UserRole, "Admin", StringComparison.OrdinalIgnoreCase))
                {
                    using (MainFormAdmin adminMain = new MainFormAdmin())
                    {
                        adminMain.ShowDialog();
                    }
                }
                else
                {
                    using (MainForm cashierMain = new MainForm(user.UserRole))
                    {
                        cashierMain.ShowDialog();
                    }
                }

                // Saat Logout dari MainForm, bersihkan sesi dan kembali tampilkan LoginForm
                UserSession.Clear();
                passwordBox.Text = string.Empty;
                showPassword.Checked = false;
                Show();
                Activate();
                usernameBox.Focus();
                usernameBox.SelectAll();
            }
            catch (SqlException ex)
            {
                Show();
                MessageBox.Show("Gagal terhubung ke SQL Server:\n" + ex.Message,
                    "Kesalahan Koneksi Database", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
            catch (Exception ex)
            {
                Show();
                MessageBox.Show("Terjadi kesalahan saat login:\n" + ex.Message,
                    "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
            finally
            {
                loginButton.Enabled = true;
            }
        }

        private void usernameBox_TextChanged(object sender, EventArgs e)
        {

        }

        private void logoLabel_Click(object sender, EventArgs e)
        {

        }

        private void pictureBox1_Click(object sender, EventArgs e)
        {

        }
    }
}
