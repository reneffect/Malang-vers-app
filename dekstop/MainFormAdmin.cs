using System;
using System.Drawing;
using System.Windows.Forms;

namespace dekstop
{
    [System.ComponentModel.DesignerCategory("Form")]
    public partial class MainFormAdmin : Form
    {
        public MainFormAdmin()
        {
            InitializeComponent();

            if (!DatabaseService.IsDesignMode())
            {
                string displayName = string.IsNullOrWhiteSpace(UserSession.Nama)
                    ? "Admin"
                    : UserSession.Nama;

                brandTitleLabel.Text = "MalangVerse Admin";
                brandSubtitleLabel.Text = displayName;
                logoLabel.Text = "M";
                Text = "MalangVerse Admin - " + displayName;

                UpdateQrisBadgeCount();
                ShowPage("Manage E-Book");
            }
        }

        private void NavButton_Click(object sender, EventArgs e)
        {
            if (sender == navEbookBtn) ShowPage("Manage E-Book");
            else if (sender == navDiscountBtn) ShowPage("Manage Discount");
            else if (sender == navQrisBtn) ShowPage("QRIS Transaction");
        }

        private void LogoutButton_Click(object sender, EventArgs e)
        {
            Close();
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
                // Koneksi database dapat belum tersedia saat form baru dibuka.
            }
        }

        public void ShowPage(string page)
        {
            Button[] adminButtons = { navEbookBtn, navDiscountBtn, navQrisBtn };
            foreach (Button button in adminButtons)
            {
                button.BackColor = Color.FromArgb(26, 34, 45);
                button.ForeColor = Color.FromArgb(203, 213, 225);
            }

            Color active = Color.FromArgb(43, 91, 226);
            UserControl view;

            switch (page)
            {
                case "Manage Discount":
                    navDiscountBtn.BackColor = active;
                    navDiscountBtn.ForeColor = Color.White;
                    view = new DiscountControl();
                    break;

                case "QRIS Transaction":
                    navQrisBtn.BackColor = active;
                    navQrisBtn.ForeColor = Color.White;
                    badgeQrisLabel.BackColor = Color.White;
                    badgeQrisLabel.ForeColor = active;
                    view = new QRISTransactionControl();
                    break;

                default:
                    navEbookBtn.BackColor = active;
                    navEbookBtn.ForeColor = Color.White;
                    view = new EbookControl();
                    break;
            }

            contentPanel.SuspendLayout();
            try
            {
                contentPanel.Controls.Clear();
                view.Dock = DockStyle.Fill;
                contentPanel.Controls.Add(view);
            }
            finally
            {
                contentPanel.ResumeLayout(true);
            }
        }

    }
}
