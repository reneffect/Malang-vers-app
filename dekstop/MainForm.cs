using System;
using System.ComponentModel;
using System.Drawing;
using System.Windows.Forms;

namespace dekstop
{
    public partial class MainForm : Form
    {
        private readonly string role;

        public MainForm() : this("Kasir")
        {
        }

        public MainForm(string userRole)
        {
            role = string.IsNullOrWhiteSpace(userRole) ? "Admin" : userRole;
            InitializeComponent();
            AttachSidebarIcon(pictureBox2, navTransactionBtn);
            AttachSidebarIcon(pictureBox3, navManagePaymentsBtn);
            AttachSidebarIcon(pictureBox4, navReceiptsBtn);
            ConfigureRoleNavigation();
        }

        private static void AttachSidebarIcon(PictureBox icon, Button button)
        {
            if (icon == null || button == null) return;
            icon.Parent = button;
            icon.BackColor = Color.Transparent;
            icon.Size = new Size(22, 22);
            icon.Location = new Point(24, Math.Max(0, (button.Height - icon.Height) / 2));
            icon.Cursor = Cursors.Hand;
            icon.Click += (s, e) => button.PerformClick();
        }

        private bool IsDesignTime()
        {
            return LicenseManager.UsageMode == LicenseUsageMode.Designtime
                || (Site != null && Site.DesignMode);
        }

        private void ConfigureRoleNavigation()
        {
            bool isAdmin = string.Equals(role, "Admin", StringComparison.OrdinalIgnoreCase);

            navEbookBtn.Visible = isAdmin;
            navDiscountBtn.Visible = isAdmin;
            navQrisBtn.Visible = isAdmin;
            badgeQrisLabel.Visible = isAdmin;

            navTransactionBtn.Visible = !isAdmin;
            navManagePaymentsBtn.Visible = !isAdmin;
            navReceiptsBtn.Visible = !isAdmin;

            string userDisplay = string.IsNullOrWhiteSpace(UserSession.Nama) ? role : UserSession.Nama;

            if (isAdmin)
            {
                brandTitleLabel.Text = "MalangVerse Admin";
                brandSubtitleLabel.Text = userDisplay;
                logoLabel.Text = "M";
                logoLabel.Font = new Font("Segoe UI", 12F, FontStyle.Bold);
                logoutButton.Text = "↪   Keluar";
                Text = "MalangVerse Admin - " + userDisplay;
                UpdateQrisBadgeCount();
                ShowPage("Manage E-Book");
            }
            else
            {
                brandTitleLabel.Text = "MalangVerse Kasir";
                brandSubtitleLabel.Text = userDisplay + " • POS";
                brandTitleLabel.Font = new Font("Georgia", 10.5F, FontStyle.Bold);
                brandSubtitleLabel.Font = new Font("Georgia", 8F);
                logoLabel.Text = "▣";
                logoLabel.Font = new Font("Segoe UI", 15F, FontStyle.Bold);
                logoutButton.Text = "↪   Logout";
                logoutButton.Font = new Font("Georgia", 9F);
                Text = "MalangVerse Kasir - " + userDisplay;
                ShowPage("Transaction");
            }
        }

        public void UpdateQrisBadgeCount()
        {
            if (DatabaseService.IsDesignMode()) return;
            try
            {
                var qrisList = DatabaseService.GetPayments("", "QRIS");
                badgeQrisLabel.Text = qrisList.Count.ToString();
            }
            catch
            {
                // Abaikan jika design-time atau koneksi belum siap
            }
        }

        private void NavButton_Click(object sender, EventArgs e)
        {
            if (sender == navEbookBtn) ShowPage("Manage E-Book");
            else if (sender == navDiscountBtn) ShowPage("Manage Discount");
            else if (sender == navQrisBtn) ShowPage("QRIS Transaction");
            else if (sender == navTransactionBtn) ShowPage("Transaction");
            else if (sender == navManagePaymentsBtn) ShowPage("Manage Payments");
            else if (sender == navReceiptsBtn) ShowPage("Receipts");
        }

        private void LogoutButton_Click(object sender, EventArgs e)
        {
            Close();
        }

        public void ShowPage(string page)
        {
            Color idleBg = Color.FromArgb(26, 34, 45);
            Color idleFg = Color.FromArgb(203, 213, 225);
            Color activeBg = string.Equals(role, "Admin", StringComparison.OrdinalIgnoreCase)
                ? Color.FromArgb(43, 91, 226)
                : Color.FromArgb(14, 71, 232);

            Button[] allButtons =
            {
                navEbookBtn, navDiscountBtn, navQrisBtn,
                navTransactionBtn, navManagePaymentsBtn, navReceiptsBtn
            };

            foreach (Button btn in allButtons)
            {
                btn.BackColor = idleBg;
                btn.ForeColor = idleFg;
            }

            badgeQrisLabel.BackColor = Color.FromArgb(16, 185, 129);
            badgeQrisLabel.ForeColor = Color.White;

            UserControl view;
            switch (page)
            {
                case "Manage E-Book":
                    navEbookBtn.BackColor = activeBg;
                    navEbookBtn.ForeColor = Color.White;
                    view = new EbookControl();
                    break;
                case "Manage Discount":
                    navDiscountBtn.BackColor = activeBg;
                    navDiscountBtn.ForeColor = Color.White;
                    view = new DiscountControl();
                    break;
                case "QRIS Transaction":
                    navQrisBtn.BackColor = activeBg;
                    navQrisBtn.ForeColor = Color.White;
                    badgeQrisLabel.BackColor = Color.White;
                    badgeQrisLabel.ForeColor = activeBg;
                    view = new QRISTransactionControl();
                    break;
                case "Manage Payments":
                    navManagePaymentsBtn.BackColor = activeBg;
                    navManagePaymentsBtn.ForeColor = Color.White;
                    view = new ManagePaymentsControl();
                    break;
                case "Receipts":
                    navReceiptsBtn.BackColor = activeBg;
                    navReceiptsBtn.ForeColor = Color.White;
                    view = new ReceiptsControl();
                    break;
                default:
                    navTransactionBtn.BackColor = activeBg;
                    navTransactionBtn.ForeColor = Color.White;
                    view = new TransactionControl();
                    break;
            }

            contentPanel.SuspendLayout();
            contentPanel.Controls.Clear();
            view.Dock = DockStyle.Fill;
            contentPanel.Controls.Add(view);
            contentPanel.ResumeLayout();
        }
    }
}
