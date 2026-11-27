using System;
using System.Drawing;
using System.Drawing.Drawing2D;
using System.Windows.Forms;

namespace dekstop
{
    [System.ComponentModel.DesignerCategory("Form")]
    public partial class MainFormAdmin : Form
    {
        private Image ebookIconActive, ebookIconInactive;
        private Image discountIconActive, discountIconInactive;
        private Image qrisIconActive, qrisIconInactive;

        public MainFormAdmin()
        {
            InitializeComponent();
            ConfigureAdminSidebarIcons();

            if (!DatabaseService.IsDesignMode())
            {
                string displayName = string.IsNullOrWhiteSpace(UserSession.Nama)
                    ? "Admin"
                    : UserSession.Nama;

                brandTitleLabel.Text = "MalangVerse Admin";
                brandSubtitleLabel.Text = displayName;
                // logoBox adalah slot PictureBox untuk logo Admin.
                // Jika properti Image diisi melalui Designer, placeholder huruf M disembunyikan.
                logoLabel.Visible = (logoBox.Image == null);
                Text = "MalangVerse Admin - " + displayName;

                UpdateQrisBadgeCount();
                ShowPage("Manage E-Book");
            }
        }


        // Ikon sidebar digambar sebagai vector-like bitmap agar bentuk, ukuran,
        // ketebalan garis, dan warna konsisten dengan referensi UI admin.
        private void ConfigureAdminSidebarIcons()
        {
            foreach (Button button in new[] { navEbookBtn, navDiscountBtn, navQrisBtn })
            {
                button.ImageAlign = ContentAlignment.MiddleLeft;
                button.TextAlign = ContentAlignment.MiddleLeft;
                button.TextImageRelation = TextImageRelation.ImageBeforeText;
                button.Padding = new Padding(21, 0, 16, 0);
                button.UseVisualStyleBackColor = false;
            }

            Color inactive = Color.FromArgb(203, 213, 225);
            ebookIconActive = CreateSidebarIcon("book", Color.White);
            ebookIconInactive = CreateSidebarIcon("book", inactive);
            discountIconActive = CreateSidebarIcon("tag", Color.White);
            discountIconInactive = CreateSidebarIcon("tag", inactive);
            qrisIconActive = CreateSidebarIcon("qris", Color.White);
            qrisIconInactive = CreateSidebarIcon("qris", inactive);

            navEbookBtn.Image = ebookIconActive;
            navDiscountBtn.Image = discountIconInactive;
            navQrisBtn.Image = qrisIconInactive;
        }

        private static Bitmap CreateSidebarIcon(string type, Color color)
        {
            const int size = 22;
            Bitmap bitmap = new Bitmap(size, size);
            using (Graphics g = Graphics.FromImage(bitmap))
            using (Pen pen = new Pen(color, 1.65f))
            using (SolidBrush brush = new SolidBrush(color))
            {
                g.SmoothingMode = SmoothingMode.AntiAlias;
                g.PixelOffsetMode = PixelOffsetMode.HighQuality;
                pen.StartCap = LineCap.Round;
                pen.EndCap = LineCap.Round;
                pen.LineJoin = LineJoin.Round;

                if (type == "book")
                {
                    // Buku terbuka dengan garis halaman di sisi kanan.
                    g.DrawArc(pen, 2.2f, 4.0f, 8.8f, 13.2f, 180, 180);
                    g.DrawArc(pen, 11.0f, 4.0f, 8.8f, 13.2f, 180, 180);
                    g.DrawLine(pen, 2.2f, 5.2f, 2.2f, 17.7f);
                    g.DrawLine(pen, 19.8f, 5.2f, 19.8f, 17.7f);
                    g.DrawLine(pen, 2.2f, 17.7f, 10.8f, 19.0f);
                    g.DrawLine(pen, 19.8f, 17.7f, 11.2f, 19.0f);
                    g.DrawLine(pen, 11.0f, 5.0f, 11.0f, 19.0f);
                    g.DrawLine(pen, 14.0f, 8.0f, 17.2f, 8.0f);
                    g.DrawLine(pen, 14.0f, 11.0f, 17.2f, 11.0f);
                    g.DrawLine(pen, 14.0f, 14.0f, 17.2f, 14.0f);
                }
                else if (type == "tag")
                {
                    // Label/tag miring dengan lubang kecil dan detail di dalamnya.
                    PointF[] pts = {
                        new PointF(3.0f, 7.0f), new PointF(3.0f, 3.0f),
                        new PointF(11.0f, 3.0f), new PointF(19.0f, 11.0f),
                        new PointF(11.0f, 19.0f)
                    };
                    g.DrawPolygon(pen, pts);
                    g.DrawEllipse(pen, 5.5f, 5.5f, 2.5f, 2.5f);
                    g.DrawLine(pen, 10.0f, 7.2f, 15.2f, 12.4f);
                    g.DrawLine(pen, 8.3f, 9.0f, 13.4f, 14.1f);
                }
                else // qris
                {
                    // Simbol QR: empat sudut pemindai dan modul di bagian dalam.
                    // kiri atas
                    g.DrawLine(pen, 3, 8, 3, 3); g.DrawLine(pen, 3, 3, 8, 3);
                    // kanan atas
                    g.DrawLine(pen, 14, 3, 19, 3); g.DrawLine(pen, 19, 3, 19, 8);
                    // kiri bawah
                    g.DrawLine(pen, 3, 14, 3, 19); g.DrawLine(pen, 3, 19, 8, 19);
                    // kanan bawah
                    g.DrawLine(pen, 14, 19, 19, 19); g.DrawLine(pen, 19, 14, 19, 19);
                    g.FillRectangle(brush, 6, 6, 2.2f, 2.2f);
                    g.FillRectangle(brush, 14.0f, 6.0f, 2.2f, 2.2f);
                    g.FillRectangle(brush, 6.0f, 14.0f, 2.2f, 2.2f);
                    g.FillRectangle(brush, 11.0f, 11.0f, 2.2f, 2.2f);
                    g.FillRectangle(brush, 16.0f, 15.0f, 2.2f, 2.2f);
                }
            }
            return bitmap;
        }

        private void UpdateAdminSidebarIconColors(string activePage)
        {
            navEbookBtn.Image = activePage == "Manage E-Book" ? ebookIconActive : ebookIconInactive;
            navDiscountBtn.Image = activePage == "Manage Discount" ? discountIconActive : discountIconInactive;
            navQrisBtn.Image = activePage == "QRIS Transaction" ? qrisIconActive : qrisIconInactive;
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
            UpdateAdminSidebarIconColors(page);
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
