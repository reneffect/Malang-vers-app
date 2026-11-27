namespace dekstop
{
    partial class PaymentDetailForm
    {
        private System.ComponentModel.IContainer components = null;
        private System.Windows.Forms.Panel topBannerPanel;
        private System.Windows.Forms.Label bannerInfoLabel;
        private System.Windows.Forms.Label statusPillLabel;
        private System.Windows.Forms.TableLayoutPanel splitLayout;
        private System.Windows.Forms.Panel leftColumnPanel;
        private System.Windows.Forms.GroupBox trxInfoGroup;
        private System.Windows.Forms.Label posTrxCaption;
        private System.Windows.Forms.TextBox posTrxBox;
        private System.Windows.Forms.Label orderIdCaption;
        private System.Windows.Forms.TextBox orderIdBox;
        private System.Windows.Forms.GroupBox itemDetailGroup;
        private System.Windows.Forms.Panel itemSummaryBox;
        private System.Windows.Forms.Label ebookNameLabel;
        private System.Windows.Forms.Label ebookLicenseLabel;
        private System.Windows.Forms.Label ebookSkuLabel;
        private System.Windows.Forms.Label totalCaptionLabel;
        private System.Windows.Forms.Label totalAmountLabel;
        private System.Windows.Forms.Label destAccountCaption;
        private System.Windows.Forms.TextBox destAccountBox;
        private System.Windows.Forms.Label payMethodCaption;
        private System.Windows.Forms.TextBox payMethodBox;
        private System.Windows.Forms.Panel bottomActionPanel;
        private System.Windows.Forms.Button rejectBtn;
        private System.Windows.Forms.Button closeBtn;
        private System.Windows.Forms.Button approveBtn;

        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        private void InitializeComponent()
        {
            this.topBannerPanel = new System.Windows.Forms.Panel();
            this.statusPillLabel = new System.Windows.Forms.Label();
            this.bannerInfoLabel = new System.Windows.Forms.Label();
            this.splitLayout = new System.Windows.Forms.TableLayoutPanel();
            this.leftColumnPanel = new System.Windows.Forms.Panel();
            this.itemDetailGroup = new System.Windows.Forms.GroupBox();
            this.payMethodBox = new System.Windows.Forms.TextBox();
            this.payMethodCaption = new System.Windows.Forms.Label();
            this.destAccountBox = new System.Windows.Forms.TextBox();
            this.destAccountCaption = new System.Windows.Forms.Label();
            this.itemSummaryBox = new System.Windows.Forms.Panel();
            this.totalAmountLabel = new System.Windows.Forms.Label();
            this.totalCaptionLabel = new System.Windows.Forms.Label();
            this.ebookSkuLabel = new System.Windows.Forms.Label();
            this.ebookLicenseLabel = new System.Windows.Forms.Label();
            this.ebookNameLabel = new System.Windows.Forms.Label();
            this.trxInfoGroup = new System.Windows.Forms.GroupBox();
            this.orderIdBox = new System.Windows.Forms.TextBox();
            this.orderIdCaption = new System.Windows.Forms.Label();
            this.posTrxBox = new System.Windows.Forms.TextBox();
            this.posTrxCaption = new System.Windows.Forms.Label();
            this.bottomActionPanel = new System.Windows.Forms.Panel();
            this.approveBtn = new System.Windows.Forms.Button();
            this.closeBtn = new System.Windows.Forms.Button();
            this.rejectBtn = new System.Windows.Forms.Button();
            this.topBannerPanel.SuspendLayout();
            this.splitLayout.SuspendLayout();
            this.leftColumnPanel.SuspendLayout();
            this.itemDetailGroup.SuspendLayout();
            this.itemSummaryBox.SuspendLayout();
            this.trxInfoGroup.SuspendLayout();
            this.bottomActionPanel.SuspendLayout();
            this.SuspendLayout();
            // 
            // topBannerPanel
            // 
            this.topBannerPanel.BackColor = System.Drawing.Color.White;
            this.topBannerPanel.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.topBannerPanel.Controls.Add(this.statusPillLabel);
            this.topBannerPanel.Controls.Add(this.bannerInfoLabel);
            this.topBannerPanel.Dock = System.Windows.Forms.DockStyle.Top;
            this.topBannerPanel.Location = new System.Drawing.Point(0, 0);
            this.topBannerPanel.Margin = new System.Windows.Forms.Padding(4);
            this.topBannerPanel.Name = "topBannerPanel";
            this.topBannerPanel.Size = new System.Drawing.Size(900, 54);
            this.topBannerPanel.TabIndex = 0;
            // 
            // statusPillLabel
            // 
            this.statusPillLabel.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.statusPillLabel.AutoSize = false;
            this.statusPillLabel.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(238)))), ((int)(((byte)(242)))), ((int)(((byte)(255)))));
            this.statusPillLabel.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.statusPillLabel.Font = new System.Drawing.Font("Segoe UI", 8F, System.Drawing.FontStyle.Bold);
            this.statusPillLabel.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(37)))), ((int)(((byte)(99)))), ((int)(((byte)(235)))));
            this.statusPillLabel.Location = new System.Drawing.Point(606, 12);
            this.statusPillLabel.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.statusPillLabel.Name = "statusPillLabel";
            this.statusPillLabel.Padding = new System.Windows.Forms.Padding(10, 4, 10, 4);
            this.statusPillLabel.Size = new System.Drawing.Size(280, 29);
            this.statusPillLabel.TabIndex = 1;
            this.statusPillLabel.Text = "Status: Menunggu Konfirmasi Kasir";
            this.statusPillLabel.TextAlign = System.Drawing.ContentAlignment.MiddleCenter;
            // 
            // bannerInfoLabel
            // 
            this.bannerInfoLabel.AutoSize = false;
            this.bannerInfoLabel.Font = new System.Drawing.Font("Segoe UI", 8.5F);
            this.bannerInfoLabel.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(51)))), ((int)(((byte)(65)))), ((int)(((byte)(85)))));
            this.bannerInfoLabel.Location = new System.Drawing.Point(19, 17);
            this.bannerInfoLabel.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.bannerInfoLabel.Name = "bannerInfoLabel";
            this.bannerInfoLabel.Size = new System.Drawing.Size(575, 20);
            this.bannerInfoLabel.TabIndex = 0;
            this.bannerInfoLabel.Text = "ⓘ  Periksa kesesuaian nominal transfer, nama pengirim, dan nomor referensi bank sebelum menyetujui.";
            // 
            // splitLayout
            // 
            this.splitLayout.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(244)))), ((int)(((byte)(246)))), ((int)(((byte)(250)))));
            this.splitLayout.ColumnCount = 1;
            this.splitLayout.ColumnStyles.Add(new System.Windows.Forms.ColumnStyle(System.Windows.Forms.SizeType.Percent, 100F));
            this.splitLayout.Controls.Add(this.leftColumnPanel, 0, 0);
            this.splitLayout.Dock = System.Windows.Forms.DockStyle.Fill;
            this.splitLayout.Location = new System.Drawing.Point(0, 54);
            this.splitLayout.Margin = new System.Windows.Forms.Padding(4);
            this.splitLayout.Name = "splitLayout";
            this.splitLayout.Padding = new System.Windows.Forms.Padding(16, 15, 16, 15);
            this.splitLayout.RowCount = 1;
            this.splitLayout.RowStyles.Add(new System.Windows.Forms.RowStyle(System.Windows.Forms.SizeType.Percent, 100F));
            this.splitLayout.Size = new System.Drawing.Size(900, 440);
            this.splitLayout.TabIndex = 1;
            // 
            // leftColumnPanel
            // 
            this.leftColumnPanel.AutoScroll = true;
            this.leftColumnPanel.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(244)))), ((int)(((byte)(246)))), ((int)(((byte)(250)))));
            this.leftColumnPanel.Controls.Add(this.itemDetailGroup);
            this.leftColumnPanel.Controls.Add(this.trxInfoGroup);
            this.leftColumnPanel.Dock = System.Windows.Forms.DockStyle.Fill;
            this.leftColumnPanel.Location = new System.Drawing.Point(16, 15);
            this.leftColumnPanel.Margin = new System.Windows.Forms.Padding(0);
            this.leftColumnPanel.Name = "leftColumnPanel";
            this.leftColumnPanel.Size = new System.Drawing.Size(868, 410);
            this.leftColumnPanel.TabIndex = 0;
            // 
            // itemDetailGroup
            // 
            this.itemDetailGroup.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left)
            | System.Windows.Forms.AnchorStyles.Right)));
            this.itemDetailGroup.BackColor = System.Drawing.Color.White;
            this.itemDetailGroup.Controls.Add(this.payMethodBox);
            this.itemDetailGroup.Controls.Add(this.payMethodCaption);
            this.itemDetailGroup.Controls.Add(this.destAccountBox);
            this.itemDetailGroup.Controls.Add(this.destAccountCaption);
            this.itemDetailGroup.Controls.Add(this.itemSummaryBox);
            this.itemDetailGroup.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.itemDetailGroup.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.itemDetailGroup.Location = new System.Drawing.Point(0, 146);
            this.itemDetailGroup.Margin = new System.Windows.Forms.Padding(4);
            this.itemDetailGroup.Name = "itemDetailGroup";
            this.itemDetailGroup.Padding = new System.Windows.Forms.Padding(4);
            this.itemDetailGroup.Size = new System.Drawing.Size(868, 240);
            this.itemDetailGroup.TabIndex = 1;
            this.itemDetailGroup.TabStop = false;
            this.itemDetailGroup.Text = "Rincian E-Book Kamus && Tagihan";
            // 
            // payMethodBox
            // 
            this.payMethodBox.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left)
            | System.Windows.Forms.AnchorStyles.Right)));
            this.payMethodBox.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(248)))), ((int)(((byte)(250)))), ((int)(((byte)(252)))));
            this.payMethodBox.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.payMethodBox.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.payMethodBox.Location = new System.Drawing.Point(442, 192);
            this.payMethodBox.Margin = new System.Windows.Forms.Padding(4);
            this.payMethodBox.Name = "payMethodBox";
            this.payMethodBox.ReadOnly = true;
            this.payMethodBox.Size = new System.Drawing.Size(408, 26);
            this.payMethodBox.TabIndex = 4;
            this.payMethodBox.Text = "QRIS";
            // 
            // payMethodCaption
            // 
            this.payMethodCaption.AutoSize = true;
            this.payMethodCaption.Font = new System.Drawing.Font("Segoe UI", 8F);
            this.payMethodCaption.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(100)))), ((int)(((byte)(116)))), ((int)(((byte)(139)))));
            this.payMethodCaption.Location = new System.Drawing.Point(442, 170);
            this.payMethodCaption.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.payMethodCaption.Name = "payMethodCaption";
            this.payMethodCaption.Size = new System.Drawing.Size(163, 19);
            this.payMethodCaption.TabIndex = 3;
            this.payMethodCaption.Text = "Metode Bayar Pengguna:";
            // 
            // destAccountBox
            // 
            this.destAccountBox.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(248)))), ((int)(((byte)(250)))), ((int)(((byte)(252)))));
            this.destAccountBox.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.destAccountBox.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.destAccountBox.Location = new System.Drawing.Point(16, 192);
            this.destAccountBox.Margin = new System.Windows.Forms.Padding(4);
            this.destAccountBox.Name = "destAccountBox";
            this.destAccountBox.ReadOnly = true;
            this.destAccountBox.Size = new System.Drawing.Size(408, 26);
            this.destAccountBox.TabIndex = 2;
            this.destAccountBox.Text = "BCA 123-456-7890 (MalangVerse)";
            // 
            // destAccountCaption
            // 
            this.destAccountCaption.AutoSize = true;
            this.destAccountCaption.Font = new System.Drawing.Font("Segoe UI", 8F);
            this.destAccountCaption.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(100)))), ((int)(((byte)(116)))), ((int)(((byte)(139)))));
            this.destAccountCaption.Location = new System.Drawing.Point(16, 170);
            this.destAccountCaption.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.destAccountCaption.Name = "destAccountCaption";
            this.destAccountCaption.Size = new System.Drawing.Size(146, 19);
            this.destAccountCaption.TabIndex = 1;
            this.destAccountCaption.Text = "Rekening Tujuan Toko:";
            // 
            // itemSummaryBox
            // 
            this.itemSummaryBox.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left)
            | System.Windows.Forms.AnchorStyles.Right)));
            this.itemSummaryBox.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(248)))), ((int)(((byte)(250)))), ((int)(((byte)(252)))));
            this.itemSummaryBox.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.itemSummaryBox.Controls.Add(this.totalAmountLabel);
            this.itemSummaryBox.Controls.Add(this.totalCaptionLabel);
            this.itemSummaryBox.Controls.Add(this.ebookSkuLabel);
            this.itemSummaryBox.Controls.Add(this.ebookLicenseLabel);
            this.itemSummaryBox.Controls.Add(this.ebookNameLabel);
            this.itemSummaryBox.Location = new System.Drawing.Point(16, 32);
            this.itemSummaryBox.Margin = new System.Windows.Forms.Padding(4);
            this.itemSummaryBox.Name = "itemSummaryBox";
            this.itemSummaryBox.Size = new System.Drawing.Size(834, 118);
            this.itemSummaryBox.TabIndex = 0;
            // 
            // totalAmountLabel
            // 
            this.totalAmountLabel.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.totalAmountLabel.AutoSize = true;
            this.totalAmountLabel.Font = new System.Drawing.Font("Segoe UI", 12F, System.Drawing.FontStyle.Bold);
            this.totalAmountLabel.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(37)))), ((int)(((byte)(99)))), ((int)(((byte)(235)))));
            this.totalAmountLabel.Location = new System.Drawing.Point(704, 52);
            this.totalAmountLabel.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.totalAmountLabel.Name = "totalAmountLabel";
            this.totalAmountLabel.Size = new System.Drawing.Size(108, 28);
            this.totalAmountLabel.TabIndex = 4;
            this.totalAmountLabel.Text = "Rp 85.000";
            // 
            // totalCaptionLabel
            // 
            this.totalCaptionLabel.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.totalCaptionLabel.AutoSize = true;
            this.totalCaptionLabel.Font = new System.Drawing.Font("Segoe UI", 8F);
            this.totalCaptionLabel.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(100)))), ((int)(((byte)(116)))), ((int)(((byte)(139)))));
            this.totalCaptionLabel.Location = new System.Drawing.Point(726, 27);
            this.totalCaptionLabel.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.totalCaptionLabel.Name = "totalCaptionLabel";
            this.totalCaptionLabel.Size = new System.Drawing.Size(88, 19);
            this.totalCaptionLabel.TabIndex = 3;
            this.totalCaptionLabel.Text = "Total Tagihan";
            // 
            // ebookSkuLabel
            // 
            this.ebookSkuLabel.AutoSize = true;
            this.ebookSkuLabel.Font = new System.Drawing.Font("Segoe UI", 7.5F);
            this.ebookSkuLabel.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(100)))), ((int)(((byte)(116)))), ((int)(((byte)(139)))));
            this.ebookSkuLabel.Location = new System.Drawing.Point(16, 76);
            this.ebookSkuLabel.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.ebookSkuLabel.Name = "ebookSkuLabel";
            this.ebookSkuLabel.Size = new System.Drawing.Size(332, 17);
            this.ebookSkuLabel.TabIndex = 2;
            this.ebookSkuLabel.Text = "SKU: EBOOK-WLM-002 • Pengiriman Otomatis via Email";
            // 
            // ebookLicenseLabel
            // 
            this.ebookLicenseLabel.AutoSize = true;
            this.ebookLicenseLabel.Font = new System.Drawing.Font("Segoe UI", 8F);
            this.ebookLicenseLabel.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(71)))), ((int)(((byte)(85)))), ((int)(((byte)(105)))));
            this.ebookLicenseLabel.Location = new System.Drawing.Point(16, 47);
            this.ebookLicenseLabel.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.ebookLicenseLabel.Name = "ebookLicenseLabel";
            this.ebookLicenseLabel.Size = new System.Drawing.Size(245, 19);
            this.ebookLicenseLabel.TabIndex = 1;
            this.ebookLicenseLabel.Text = "Lisensi: Single User (Digital PDF & EPUB)";
            // 
            // ebookNameLabel
            // 
            this.ebookNameLabel.AutoSize = true;
            this.ebookNameLabel.Font = new System.Drawing.Font("Segoe UI", 9.5F, System.Drawing.FontStyle.Bold);
            this.ebookNameLabel.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.ebookNameLabel.Location = new System.Drawing.Point(16, 20);
            this.ebookNameLabel.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.ebookNameLabel.Name = "ebookNameLabel";
            this.ebookNameLabel.Size = new System.Drawing.Size(269, 21);
            this.ebookNameLabel.TabIndex = 0;
            this.ebookNameLabel.Text = "Kamus Bahasa Walikan Malang v2";
            // 
            // trxInfoGroup
            // 
            this.trxInfoGroup.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left)
            | System.Windows.Forms.AnchorStyles.Right)));
            this.trxInfoGroup.BackColor = System.Drawing.Color.White;
            this.trxInfoGroup.Controls.Add(this.orderIdBox);
            this.trxInfoGroup.Controls.Add(this.orderIdCaption);
            this.trxInfoGroup.Controls.Add(this.posTrxBox);
            this.trxInfoGroup.Controls.Add(this.posTrxCaption);
            this.trxInfoGroup.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.trxInfoGroup.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.trxInfoGroup.Location = new System.Drawing.Point(0, 0);
            this.trxInfoGroup.Margin = new System.Windows.Forms.Padding(4);
            this.trxInfoGroup.Name = "trxInfoGroup";
            this.trxInfoGroup.Padding = new System.Windows.Forms.Padding(4);
            this.trxInfoGroup.Size = new System.Drawing.Size(868, 130);
            this.trxInfoGroup.TabIndex = 0;
            this.trxInfoGroup.TabStop = false;
            this.trxInfoGroup.Text = "Informasi Transaksi";
            // 
            // orderIdBox
            // 
            this.orderIdBox.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left)
            | System.Windows.Forms.AnchorStyles.Right)));
            this.orderIdBox.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(248)))), ((int)(((byte)(250)))), ((int)(((byte)(252)))));
            this.orderIdBox.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.orderIdBox.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.orderIdBox.Location = new System.Drawing.Point(442, 64);
            this.orderIdBox.Margin = new System.Windows.Forms.Padding(4);
            this.orderIdBox.Name = "orderIdBox";
            this.orderIdBox.ReadOnly = true;
            this.orderIdBox.Size = new System.Drawing.Size(408, 26);
            this.orderIdBox.TabIndex = 3;
            this.orderIdBox.Text = "ORD-2026-0891";
            // 
            // orderIdCaption
            // 
            this.orderIdCaption.AutoSize = true;
            this.orderIdCaption.Font = new System.Drawing.Font("Segoe UI", 8F);
            this.orderIdCaption.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(100)))), ((int)(((byte)(116)))), ((int)(((byte)(139)))));
            this.orderIdCaption.Location = new System.Drawing.Point(442, 42);
            this.orderIdCaption.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.orderIdCaption.Name = "orderIdCaption";
            this.orderIdCaption.Size = new System.Drawing.Size(113, 19);
            this.orderIdCaption.TabIndex = 2;
            this.orderIdCaption.Text = "ID Pesanan Toko:";
            // 
            // posTrxBox
            // 
            this.posTrxBox.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(248)))), ((int)(((byte)(250)))), ((int)(((byte)(252)))));
            this.posTrxBox.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.posTrxBox.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.posTrxBox.Location = new System.Drawing.Point(16, 64);
            this.posTrxBox.Margin = new System.Windows.Forms.Padding(4);
            this.posTrxBox.Name = "posTrxBox";
            this.posTrxBox.ReadOnly = true;
            this.posTrxBox.Size = new System.Drawing.Size(408, 26);
            this.posTrxBox.TabIndex = 1;
            this.posTrxBox.Text = "TRX-MV-89102";
            // 
            // posTrxCaption
            // 
            this.posTrxCaption.AutoSize = true;
            this.posTrxCaption.Font = new System.Drawing.Font("Segoe UI", 8F);
            this.posTrxCaption.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(100)))), ((int)(((byte)(116)))), ((int)(((byte)(139)))));
            this.posTrxCaption.Location = new System.Drawing.Point(16, 42);
            this.posTrxCaption.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.posTrxCaption.Name = "posTrxCaption";
            this.posTrxCaption.Size = new System.Drawing.Size(115, 19);
            this.posTrxCaption.TabIndex = 0;
            this.posTrxCaption.Text = "ID Transaksi POS:";
            // 
            // bottomActionPanel
            // 
            this.bottomActionPanel.BackColor = System.Drawing.Color.White;
            this.bottomActionPanel.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.bottomActionPanel.Controls.Add(this.approveBtn);
            this.bottomActionPanel.Controls.Add(this.closeBtn);
            this.bottomActionPanel.Controls.Add(this.rejectBtn);
            this.bottomActionPanel.Dock = System.Windows.Forms.DockStyle.Bottom;
            this.bottomActionPanel.Location = new System.Drawing.Point(0, 494);
            this.bottomActionPanel.Margin = new System.Windows.Forms.Padding(4);
            this.bottomActionPanel.Name = "bottomActionPanel";
            this.bottomActionPanel.Size = new System.Drawing.Size(900, 66);
            this.bottomActionPanel.TabIndex = 2;
            // 
            // approveBtn
            // 
            this.approveBtn.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.approveBtn.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(37)))), ((int)(((byte)(99)))), ((int)(((byte)(235)))));
            this.approveBtn.Cursor = System.Windows.Forms.Cursors.Hand;
            this.approveBtn.FlatAppearance.BorderSize = 0;
            this.approveBtn.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.approveBtn.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.approveBtn.ForeColor = System.Drawing.Color.White;
            this.approveBtn.Location = new System.Drawing.Point(677, 12);
            this.approveBtn.Margin = new System.Windows.Forms.Padding(4);
            this.approveBtn.Name = "approveBtn";
            this.approveBtn.Size = new System.Drawing.Size(203, 42);
            this.approveBtn.TabIndex = 2;
            this.approveBtn.Text = "✔  Verifikasi (Approve)";
            this.approveBtn.UseVisualStyleBackColor = false;
            this.approveBtn.Click += new System.EventHandler(this.ApproveBtn_Click);
            // 
            // closeBtn
            // 
            this.closeBtn.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.closeBtn.BackColor = System.Drawing.Color.White;
            this.closeBtn.Cursor = System.Windows.Forms.Cursors.Hand;
            this.closeBtn.FlatAppearance.BorderColor = System.Drawing.Color.FromArgb(((int)(((byte)(203)))), ((int)(((byte)(213)))), ((int)(((byte)(225)))));
            this.closeBtn.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.closeBtn.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.closeBtn.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(51)))), ((int)(((byte)(65)))), ((int)(((byte)(85)))));
            this.closeBtn.Location = new System.Drawing.Point(520, 12);
            this.closeBtn.Margin = new System.Windows.Forms.Padding(4);
            this.closeBtn.Name = "closeBtn";
            this.closeBtn.Size = new System.Drawing.Size(147, 42);
            this.closeBtn.TabIndex = 1;
            this.closeBtn.Text = "Tutup / Kembali";
            this.closeBtn.UseVisualStyleBackColor = false;
            this.closeBtn.Click += new System.EventHandler(this.CloseBtn_Click);
            // 
            // rejectBtn
            // 
            this.rejectBtn.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.rejectBtn.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(254)))), ((int)(((byte)(242)))), ((int)(((byte)(242)))));
            this.rejectBtn.Cursor = System.Windows.Forms.Cursors.Hand;
            this.rejectBtn.FlatAppearance.BorderColor = System.Drawing.Color.FromArgb(((int)(((byte)(252)))), ((int)(((byte)(165)))), ((int)(((byte)(165)))));
            this.rejectBtn.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.rejectBtn.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.rejectBtn.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(220)))), ((int)(((byte)(38)))), ((int)(((byte)(38)))));
            this.rejectBtn.Location = new System.Drawing.Point(357, 12);
            this.rejectBtn.Margin = new System.Windows.Forms.Padding(4);
            this.rejectBtn.Name = "rejectBtn";
            this.rejectBtn.Size = new System.Drawing.Size(152, 42);
            this.rejectBtn.TabIndex = 0;
            this.rejectBtn.Text = "✕  Tolak (Reject)";
            this.rejectBtn.UseVisualStyleBackColor = false;
            this.rejectBtn.Click += new System.EventHandler(this.RejectBtn_Click);
            // 
            // PaymentDetailForm
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(8F, 16F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(244)))), ((int)(((byte)(246)))), ((int)(((byte)(250)))));
            this.ClientSize = new System.Drawing.Size(900, 560);
            this.Controls.Add(this.splitLayout);
            this.Controls.Add(this.bottomActionPanel);
            this.Controls.Add(this.topBannerPanel);
            this.Margin = new System.Windows.Forms.Padding(4);
            this.MinimumSize = new System.Drawing.Size(760, 520);
            this.Name = "PaymentDetailForm";
            this.StartPosition = System.Windows.Forms.FormStartPosition.CenterParent;
            this.Text = "Digital Payment Proof Verification - TRX-MV-89102";
            this.topBannerPanel.ResumeLayout(false);
            this.topBannerPanel.PerformLayout();
            this.splitLayout.ResumeLayout(false);
            this.leftColumnPanel.ResumeLayout(false);
            this.itemDetailGroup.ResumeLayout(false);
            this.itemDetailGroup.PerformLayout();
            this.itemSummaryBox.ResumeLayout(false);
            this.itemSummaryBox.PerformLayout();
            this.trxInfoGroup.ResumeLayout(false);
            this.trxInfoGroup.PerformLayout();
            this.bottomActionPanel.ResumeLayout(false);
            this.ResumeLayout(false);

        }

        #endregion
    }
}
