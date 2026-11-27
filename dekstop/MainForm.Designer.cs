namespace dekstop
{
    partial class MainForm
    {
        private System.ComponentModel.IContainer components = null;
        private System.Windows.Forms.Panel sidebarPanel;
        private System.Windows.Forms.Panel brandPanel;
        private System.Windows.Forms.Panel logoBox;
        private System.Windows.Forms.Label logoLabel;
        private System.Windows.Forms.Label brandTitleLabel;
        private System.Windows.Forms.Label brandSubtitleLabel;
        private System.Windows.Forms.Panel brandDivider;
        private System.Windows.Forms.Panel menuPanel;
        private System.Windows.Forms.Button navEbookBtn;
        private System.Windows.Forms.Button navDiscountBtn;
        private System.Windows.Forms.Button navQrisBtn;
        private System.Windows.Forms.Label badgeQrisLabel;
        private System.Windows.Forms.Button navTransactionBtn;
        private System.Windows.Forms.Button navManagePaymentsBtn;
        private System.Windows.Forms.Button navReceiptsBtn;
        private System.Windows.Forms.Panel footerPanel;
        private System.Windows.Forms.Panel footerDivider;
        private System.Windows.Forms.Button logoutButton;
        private System.Windows.Forms.Panel contentPanel;

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
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(MainForm));
            this.sidebarPanel = new System.Windows.Forms.Panel();
            this.menuPanel = new System.Windows.Forms.Panel();
            this.navReceiptsBtn = new System.Windows.Forms.Button();
            this.navManagePaymentsBtn = new System.Windows.Forms.Button();
            this.navTransactionBtn = new System.Windows.Forms.Button();
            this.badgeQrisLabel = new System.Windows.Forms.Label();
            this.navQrisBtn = new System.Windows.Forms.Button();
            this.navDiscountBtn = new System.Windows.Forms.Button();
            this.navEbookBtn = new System.Windows.Forms.Button();
            this.footerPanel = new System.Windows.Forms.Panel();
            this.logoutButton = new System.Windows.Forms.Button();
            this.footerDivider = new System.Windows.Forms.Panel();
            this.brandPanel = new System.Windows.Forms.Panel();
            this.brandDivider = new System.Windows.Forms.Panel();
            this.brandSubtitleLabel = new System.Windows.Forms.Label();
            this.brandTitleLabel = new System.Windows.Forms.Label();
            this.logoBox = new System.Windows.Forms.Panel();
            this.logoLabel = new System.Windows.Forms.Label();
            this.contentPanel = new System.Windows.Forms.Panel();
            this.pictureBox1 = new System.Windows.Forms.PictureBox();
            this.pictureBox2 = new System.Windows.Forms.PictureBox();
            this.panel1 = new System.Windows.Forms.Panel();
            this.pictureBox3 = new System.Windows.Forms.PictureBox();
            this.pictureBox4 = new System.Windows.Forms.PictureBox();
            this.sidebarPanel.SuspendLayout();
            this.menuPanel.SuspendLayout();
            this.footerPanel.SuspendLayout();
            this.brandPanel.SuspendLayout();
            this.logoBox.SuspendLayout();
            this.contentPanel.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.pictureBox1)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.pictureBox2)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.pictureBox3)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.pictureBox4)).BeginInit();
            this.SuspendLayout();
            // 
            // sidebarPanel
            // 
            this.sidebarPanel.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(26)))), ((int)(((byte)(34)))), ((int)(((byte)(45)))));
            this.sidebarPanel.Controls.Add(this.menuPanel);
            this.sidebarPanel.Controls.Add(this.footerPanel);
            this.sidebarPanel.Controls.Add(this.brandPanel);
            this.sidebarPanel.Dock = System.Windows.Forms.DockStyle.Left;
            this.sidebarPanel.Location = new System.Drawing.Point(0, 0);
            this.sidebarPanel.Margin = new System.Windows.Forms.Padding(4);
            this.sidebarPanel.Name = "sidebarPanel";
            this.sidebarPanel.Size = new System.Drawing.Size(304, 935);
            this.sidebarPanel.TabIndex = 0;
            // 
            // menuPanel
            // 
            this.menuPanel.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(26)))), ((int)(((byte)(34)))), ((int)(((byte)(45)))));
            this.menuPanel.Controls.Add(this.pictureBox4);
            this.menuPanel.Controls.Add(this.pictureBox2);
            this.menuPanel.Controls.Add(this.pictureBox3);
            this.menuPanel.Controls.Add(this.navReceiptsBtn);
            this.menuPanel.Controls.Add(this.navManagePaymentsBtn);
            this.menuPanel.Controls.Add(this.navTransactionBtn);
            this.menuPanel.Controls.Add(this.badgeQrisLabel);
            this.menuPanel.Controls.Add(this.navQrisBtn);
            this.menuPanel.Controls.Add(this.navDiscountBtn);
            this.menuPanel.Controls.Add(this.navEbookBtn);
            this.menuPanel.Dock = System.Windows.Forms.DockStyle.Fill;
            this.menuPanel.Location = new System.Drawing.Point(0, 89);
            this.menuPanel.Margin = new System.Windows.Forms.Padding(4);
            this.menuPanel.Name = "menuPanel";
            this.menuPanel.Size = new System.Drawing.Size(304, 780);
            this.menuPanel.TabIndex = 1;
            // 
            // navReceiptsBtn
            // 
            this.navReceiptsBtn.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(26)))), ((int)(((byte)(34)))), ((int)(((byte)(45)))));
            this.navReceiptsBtn.Cursor = System.Windows.Forms.Cursors.Hand;
            this.navReceiptsBtn.FlatAppearance.BorderSize = 0;
            this.navReceiptsBtn.FlatAppearance.MouseOverBackColor = System.Drawing.Color.FromArgb(((int)(((byte)(37)))), ((int)(((byte)(49)))), ((int)(((byte)(66)))));
            this.navReceiptsBtn.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.navReceiptsBtn.Font = new System.Drawing.Font("Georgia", 9F);
            this.navReceiptsBtn.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(203)))), ((int)(((byte)(213)))), ((int)(((byte)(225)))));
            this.navReceiptsBtn.Location = new System.Drawing.Point(0, 118);
            this.navReceiptsBtn.Margin = new System.Windows.Forms.Padding(4);
            this.navReceiptsBtn.Name = "navReceiptsBtn";
            this.navReceiptsBtn.Padding = new System.Windows.Forms.Padding(21, 0, 16, 0);
            this.navReceiptsBtn.Size = new System.Drawing.Size(304, 49);
            this.navReceiptsBtn.TabIndex = 6;
            this.navReceiptsBtn.Text = "🧾   Receipts";
            this.navReceiptsBtn.TextAlign = System.Drawing.ContentAlignment.MiddleLeft;
            this.navReceiptsBtn.UseVisualStyleBackColor = false;
            this.navReceiptsBtn.Click += new System.EventHandler(this.NavButton_Click);
            // 
            // navManagePaymentsBtn
            // 
            this.navManagePaymentsBtn.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(26)))), ((int)(((byte)(34)))), ((int)(((byte)(45)))));
            this.navManagePaymentsBtn.Cursor = System.Windows.Forms.Cursors.Hand;
            this.navManagePaymentsBtn.FlatAppearance.BorderSize = 0;
            this.navManagePaymentsBtn.FlatAppearance.MouseOverBackColor = System.Drawing.Color.FromArgb(((int)(((byte)(37)))), ((int)(((byte)(49)))), ((int)(((byte)(66)))));
            this.navManagePaymentsBtn.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.navManagePaymentsBtn.Font = new System.Drawing.Font("Georgia", 9F);
            this.navManagePaymentsBtn.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(203)))), ((int)(((byte)(213)))), ((int)(((byte)(225)))));
            this.navManagePaymentsBtn.Location = new System.Drawing.Point(0, 66);
            this.navManagePaymentsBtn.Margin = new System.Windows.Forms.Padding(4);
            this.navManagePaymentsBtn.Name = "navManagePaymentsBtn";
            this.navManagePaymentsBtn.Padding = new System.Windows.Forms.Padding(21, 0, 16, 0);
            this.navManagePaymentsBtn.Size = new System.Drawing.Size(304, 49);
            this.navManagePaymentsBtn.TabIndex = 5;
            this.navManagePaymentsBtn.Text = "💳   Manage Payments";
            this.navManagePaymentsBtn.TextAlign = System.Drawing.ContentAlignment.MiddleLeft;
            this.navManagePaymentsBtn.UseVisualStyleBackColor = false;
            this.navManagePaymentsBtn.Click += new System.EventHandler(this.NavButton_Click);
            // 
            // navTransactionBtn
            // 
            this.navTransactionBtn.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(26)))), ((int)(((byte)(34)))), ((int)(((byte)(45)))));
            this.navTransactionBtn.Cursor = System.Windows.Forms.Cursors.Hand;
            this.navTransactionBtn.FlatAppearance.BorderSize = 0;
            this.navTransactionBtn.FlatAppearance.MouseOverBackColor = System.Drawing.Color.FromArgb(((int)(((byte)(37)))), ((int)(((byte)(49)))), ((int)(((byte)(66)))));
            this.navTransactionBtn.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.navTransactionBtn.Font = new System.Drawing.Font("Georgia", 9F);
            this.navTransactionBtn.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(203)))), ((int)(((byte)(213)))), ((int)(((byte)(225)))));
            this.navTransactionBtn.Location = new System.Drawing.Point(0, 15);
            this.navTransactionBtn.Margin = new System.Windows.Forms.Padding(4);
            this.navTransactionBtn.Name = "navTransactionBtn";
            this.navTransactionBtn.Padding = new System.Windows.Forms.Padding(21, 0, 16, 0);
            this.navTransactionBtn.Size = new System.Drawing.Size(304, 49);
            this.navTransactionBtn.TabIndex = 4;
            this.navTransactionBtn.Text = "🏧   Transaction";
            this.navTransactionBtn.TextAlign = System.Drawing.ContentAlignment.MiddleLeft;
            this.navTransactionBtn.UseVisualStyleBackColor = false;
            this.navTransactionBtn.Click += new System.EventHandler(this.NavButton_Click);
            // 
            // badgeQrisLabel
            // 
            this.badgeQrisLabel.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(16)))), ((int)(((byte)(185)))), ((int)(((byte)(129)))));
            this.badgeQrisLabel.Font = new System.Drawing.Font("Segoe UI", 7.5F, System.Drawing.FontStyle.Bold);
            this.badgeQrisLabel.ForeColor = System.Drawing.Color.White;
            this.badgeQrisLabel.Location = new System.Drawing.Point(224, 132);
            this.badgeQrisLabel.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.badgeQrisLabel.Name = "badgeQrisLabel";
            this.badgeQrisLabel.Size = new System.Drawing.Size(64, 22);
            this.badgeQrisLabel.TabIndex = 3;
            this.badgeQrisLabel.Text = "New: 14";
            this.badgeQrisLabel.TextAlign = System.Drawing.ContentAlignment.MiddleCenter;
            this.badgeQrisLabel.Visible = false;
            // 
            // navQrisBtn
            // 
            this.navQrisBtn.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(26)))), ((int)(((byte)(34)))), ((int)(((byte)(45)))));
            this.navQrisBtn.Cursor = System.Windows.Forms.Cursors.Hand;
            this.navQrisBtn.FlatAppearance.BorderSize = 0;
            this.navQrisBtn.FlatAppearance.MouseOverBackColor = System.Drawing.Color.FromArgb(((int)(((byte)(37)))), ((int)(((byte)(49)))), ((int)(((byte)(66)))));
            this.navQrisBtn.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.navQrisBtn.Font = new System.Drawing.Font("Segoe UI", 9F);
            this.navQrisBtn.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(203)))), ((int)(((byte)(213)))), ((int)(((byte)(225)))));
            this.navQrisBtn.Location = new System.Drawing.Point(0, 118);
            this.navQrisBtn.Margin = new System.Windows.Forms.Padding(4);
            this.navQrisBtn.Name = "navQrisBtn";
            this.navQrisBtn.Padding = new System.Windows.Forms.Padding(21, 0, 16, 0);
            this.navQrisBtn.Size = new System.Drawing.Size(304, 49);
            this.navQrisBtn.TabIndex = 2;
            this.navQrisBtn.Text = "⊞   QRIS Transaction";
            this.navQrisBtn.TextAlign = System.Drawing.ContentAlignment.MiddleLeft;
            this.navQrisBtn.UseVisualStyleBackColor = false;
            this.navQrisBtn.Visible = false;
            this.navQrisBtn.Click += new System.EventHandler(this.NavButton_Click);
            // 
            // navDiscountBtn
            // 
            this.navDiscountBtn.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(26)))), ((int)(((byte)(34)))), ((int)(((byte)(45)))));
            this.navDiscountBtn.Cursor = System.Windows.Forms.Cursors.Hand;
            this.navDiscountBtn.FlatAppearance.BorderSize = 0;
            this.navDiscountBtn.FlatAppearance.MouseOverBackColor = System.Drawing.Color.FromArgb(((int)(((byte)(37)))), ((int)(((byte)(49)))), ((int)(((byte)(66)))));
            this.navDiscountBtn.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.navDiscountBtn.Font = new System.Drawing.Font("Segoe UI", 9F);
            this.navDiscountBtn.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(203)))), ((int)(((byte)(213)))), ((int)(((byte)(225)))));
            this.navDiscountBtn.Location = new System.Drawing.Point(0, 66);
            this.navDiscountBtn.Margin = new System.Windows.Forms.Padding(4);
            this.navDiscountBtn.Name = "navDiscountBtn";
            this.navDiscountBtn.Padding = new System.Windows.Forms.Padding(21, 0, 16, 0);
            this.navDiscountBtn.Size = new System.Drawing.Size(304, 49);
            this.navDiscountBtn.TabIndex = 1;
            this.navDiscountBtn.Text = "🏷   Manage Discount";
            this.navDiscountBtn.TextAlign = System.Drawing.ContentAlignment.MiddleLeft;
            this.navDiscountBtn.UseVisualStyleBackColor = false;
            this.navDiscountBtn.Visible = false;
            this.navDiscountBtn.Click += new System.EventHandler(this.NavButton_Click);
            // 
            // navEbookBtn
            // 
            this.navEbookBtn.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(43)))), ((int)(((byte)(91)))), ((int)(((byte)(226)))));
            this.navEbookBtn.Cursor = System.Windows.Forms.Cursors.Hand;
            this.navEbookBtn.FlatAppearance.BorderSize = 0;
            this.navEbookBtn.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.navEbookBtn.Font = new System.Drawing.Font("Segoe UI", 9F, System.Drawing.FontStyle.Bold);
            this.navEbookBtn.ForeColor = System.Drawing.Color.White;
            this.navEbookBtn.Location = new System.Drawing.Point(0, 15);
            this.navEbookBtn.Margin = new System.Windows.Forms.Padding(4);
            this.navEbookBtn.Name = "navEbookBtn";
            this.navEbookBtn.Padding = new System.Windows.Forms.Padding(21, 0, 16, 0);
            this.navEbookBtn.Size = new System.Drawing.Size(304, 49);
            this.navEbookBtn.TabIndex = 0;
            this.navEbookBtn.Text = "📖   Manage E-Book";
            this.navEbookBtn.TextAlign = System.Drawing.ContentAlignment.MiddleLeft;
            this.navEbookBtn.UseVisualStyleBackColor = false;
            this.navEbookBtn.Visible = false;
            this.navEbookBtn.Click += new System.EventHandler(this.NavButton_Click);
            // 
            // footerPanel
            // 
            this.footerPanel.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(26)))), ((int)(((byte)(34)))), ((int)(((byte)(45)))));
            this.footerPanel.Controls.Add(this.logoutButton);
            this.footerPanel.Controls.Add(this.footerDivider);
            this.footerPanel.Dock = System.Windows.Forms.DockStyle.Bottom;
            this.footerPanel.Location = new System.Drawing.Point(0, 869);
            this.footerPanel.Margin = new System.Windows.Forms.Padding(4);
            this.footerPanel.Name = "footerPanel";
            this.footerPanel.Size = new System.Drawing.Size(304, 66);
            this.footerPanel.TabIndex = 2;
            // 
            // logoutButton
            // 
            this.logoutButton.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(26)))), ((int)(((byte)(34)))), ((int)(((byte)(45)))));
            this.logoutButton.Cursor = System.Windows.Forms.Cursors.Hand;
            this.logoutButton.Dock = System.Windows.Forms.DockStyle.Fill;
            this.logoutButton.FlatAppearance.BorderSize = 0;
            this.logoutButton.FlatAppearance.MouseOverBackColor = System.Drawing.Color.FromArgb(((int)(((byte)(37)))), ((int)(((byte)(49)))), ((int)(((byte)(66)))));
            this.logoutButton.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.logoutButton.Font = new System.Drawing.Font("Segoe UI", 9F);
            this.logoutButton.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(148)))), ((int)(((byte)(163)))), ((int)(((byte)(184)))));
            this.logoutButton.Location = new System.Drawing.Point(0, 1);
            this.logoutButton.Margin = new System.Windows.Forms.Padding(4);
            this.logoutButton.Name = "logoutButton";
            this.logoutButton.Padding = new System.Windows.Forms.Padding(24, 0, 16, 0);
            this.logoutButton.Size = new System.Drawing.Size(304, 65);
            this.logoutButton.TabIndex = 1;
            this.logoutButton.Text = "↪   Logout";
            this.logoutButton.TextAlign = System.Drawing.ContentAlignment.MiddleLeft;
            this.logoutButton.UseVisualStyleBackColor = false;
            this.logoutButton.Click += new System.EventHandler(this.LogoutButton_Click);
            // 
            // footerDivider
            // 
            this.footerDivider.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(42)))), ((int)(((byte)(52)))), ((int)(((byte)(68)))));
            this.footerDivider.Dock = System.Windows.Forms.DockStyle.Top;
            this.footerDivider.Location = new System.Drawing.Point(0, 0);
            this.footerDivider.Margin = new System.Windows.Forms.Padding(4);
            this.footerDivider.Name = "footerDivider";
            this.footerDivider.Size = new System.Drawing.Size(304, 1);
            this.footerDivider.TabIndex = 0;
            // 
            // brandPanel
            // 
            this.brandPanel.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(26)))), ((int)(((byte)(34)))), ((int)(((byte)(45)))));
            this.brandPanel.Controls.Add(this.brandDivider);
            this.brandPanel.Controls.Add(this.brandSubtitleLabel);
            this.brandPanel.Controls.Add(this.brandTitleLabel);
            this.brandPanel.Controls.Add(this.logoBox);
            this.brandPanel.Dock = System.Windows.Forms.DockStyle.Top;
            this.brandPanel.Location = new System.Drawing.Point(0, 0);
            this.brandPanel.Margin = new System.Windows.Forms.Padding(4);
            this.brandPanel.Name = "brandPanel";
            this.brandPanel.Size = new System.Drawing.Size(304, 89);
            this.brandPanel.TabIndex = 0;
            // 
            // brandDivider
            // 
            this.brandDivider.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(42)))), ((int)(((byte)(52)))), ((int)(((byte)(68)))));
            this.brandDivider.Dock = System.Windows.Forms.DockStyle.Bottom;
            this.brandDivider.Location = new System.Drawing.Point(0, 88);
            this.brandDivider.Margin = new System.Windows.Forms.Padding(4);
            this.brandDivider.Name = "brandDivider";
            this.brandDivider.Size = new System.Drawing.Size(304, 1);
            this.brandDivider.TabIndex = 3;
            // 
            // brandSubtitleLabel
            // 
            this.brandSubtitleLabel.AutoSize = true;
            this.brandSubtitleLabel.Font = new System.Drawing.Font("Georgia", 8F);
            this.brandSubtitleLabel.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(148)))), ((int)(((byte)(163)))), ((int)(((byte)(184)))));
            this.brandSubtitleLabel.Location = new System.Drawing.Point(83, 48);
            this.brandSubtitleLabel.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.brandSubtitleLabel.Name = "brandSubtitleLabel";
            this.brandSubtitleLabel.Size = new System.Drawing.Size(96, 17);
            this.brandSubtitleLabel.TabIndex = 2;
            this.brandSubtitleLabel.Text = "Terminal POS";
            // 
            // brandTitleLabel
            // 
            this.brandTitleLabel.AutoSize = true;
            this.brandTitleLabel.Font = new System.Drawing.Font("Georgia", 10.5F, System.Drawing.FontStyle.Bold);
            this.brandTitleLabel.ForeColor = System.Drawing.Color.White;
            this.brandTitleLabel.Location = new System.Drawing.Point(83, 22);
            this.brandTitleLabel.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.brandTitleLabel.Name = "brandTitleLabel";
            this.brandTitleLabel.Size = new System.Drawing.Size(186, 21);
            this.brandTitleLabel.TabIndex = 1;
            this.brandTitleLabel.Text = "MalangVerse Kasir";
            // 
            // logoBox
            // 
            this.logoBox.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(43)))), ((int)(((byte)(91)))), ((int)(((byte)(226)))));
            this.logoBox.Controls.Add(this.pictureBox1);
            this.logoBox.Controls.Add(this.logoLabel);
            this.logoBox.Location = new System.Drawing.Point(21, 21);
            this.logoBox.Margin = new System.Windows.Forms.Padding(4);
            this.logoBox.Name = "logoBox";
            this.logoBox.Size = new System.Drawing.Size(48, 44);
            this.logoBox.TabIndex = 0;
            // 
            // logoLabel
            // 
            this.logoLabel.Dock = System.Windows.Forms.DockStyle.Fill;
            this.logoLabel.Font = new System.Drawing.Font("Segoe UI", 12F, System.Drawing.FontStyle.Bold);
            this.logoLabel.ForeColor = System.Drawing.Color.White;
            this.logoLabel.Location = new System.Drawing.Point(0, 0);
            this.logoLabel.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.logoLabel.Name = "logoLabel";
            this.logoLabel.Size = new System.Drawing.Size(48, 44);
            this.logoLabel.TabIndex = 0;
            this.logoLabel.Text = "M";
            this.logoLabel.TextAlign = System.Drawing.ContentAlignment.MiddleCenter;
            // 
            // contentPanel
            // 
            this.contentPanel.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(244)))), ((int)(((byte)(246)))), ((int)(((byte)(250)))));
            this.contentPanel.Controls.Add(this.panel1);
            this.contentPanel.Dock = System.Windows.Forms.DockStyle.Fill;
            this.contentPanel.Location = new System.Drawing.Point(304, 0);
            this.contentPanel.Margin = new System.Windows.Forms.Padding(4);
            this.contentPanel.Name = "contentPanel";
            this.contentPanel.Size = new System.Drawing.Size(1517, 935);
            this.contentPanel.TabIndex = 1;
            // 
            // pictureBox1
            // 
            this.pictureBox1.Image = ((System.Drawing.Image)(resources.GetObject("pictureBox1.Image")));
            this.pictureBox1.Location = new System.Drawing.Point(-21, -6);
            this.pictureBox1.Name = "pictureBox1";
            this.pictureBox1.Size = new System.Drawing.Size(92, 50);
            this.pictureBox1.SizeMode = System.Windows.Forms.PictureBoxSizeMode.Zoom;
            this.pictureBox1.TabIndex = 0;
            this.pictureBox1.TabStop = false;
            // 
            // pictureBox2
            // 
            this.pictureBox2.Image = ((System.Drawing.Image)(resources.GetObject("pictureBox2.Image")));
            this.pictureBox2.Location = new System.Drawing.Point(26, 15);
            this.pictureBox2.Name = "pictureBox2";
            this.pictureBox2.Size = new System.Drawing.Size(27, 50);
            this.pictureBox2.SizeMode = System.Windows.Forms.PictureBoxSizeMode.Zoom;
            this.pictureBox2.TabIndex = 0;
            this.pictureBox2.TabStop = false;
            // 
            // panel1
            // 
            this.panel1.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(244)))), ((int)(((byte)(246)))), ((int)(((byte)(250)))));
            this.panel1.Dock = System.Windows.Forms.DockStyle.Fill;
            this.panel1.Location = new System.Drawing.Point(0, 0);
            this.panel1.Margin = new System.Windows.Forms.Padding(4);
            this.panel1.Name = "panel1";
            this.panel1.Size = new System.Drawing.Size(1517, 935);
            this.panel1.TabIndex = 2;
            // 
            // pictureBox3
            // 
            this.pictureBox3.Image = ((System.Drawing.Image)(resources.GetObject("pictureBox3.Image")));
            this.pictureBox3.Location = new System.Drawing.Point(26, 71);
            this.pictureBox3.Name = "pictureBox3";
            this.pictureBox3.Size = new System.Drawing.Size(27, 50);
            this.pictureBox3.SizeMode = System.Windows.Forms.PictureBoxSizeMode.Zoom;
            this.pictureBox3.TabIndex = 7;
            this.pictureBox3.TabStop = false;
            // 
            // pictureBox4
            // 
            this.pictureBox4.Image = ((System.Drawing.Image)(resources.GetObject("pictureBox4.Image")));
            this.pictureBox4.Location = new System.Drawing.Point(26, 122);
            this.pictureBox4.Name = "pictureBox4";
            this.pictureBox4.Size = new System.Drawing.Size(27, 50);
            this.pictureBox4.SizeMode = System.Windows.Forms.PictureBoxSizeMode.Zoom;
            this.pictureBox4.TabIndex = 8;
            this.pictureBox4.TabStop = false;
            // 
            // MainForm
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(8F, 16F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(244)))), ((int)(((byte)(246)))), ((int)(((byte)(250)))));
            this.ClientSize = new System.Drawing.Size(1821, 935);
            this.Controls.Add(this.contentPanel);
            this.Controls.Add(this.sidebarPanel);
            this.Margin = new System.Windows.Forms.Padding(4);
            this.MinimumSize = new System.Drawing.Size(1567, 826);
            this.Name = "MainForm";
            this.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen;
            this.Text = "MalangVerse Kasir";
            this.WindowState = System.Windows.Forms.FormWindowState.Maximized;
            this.sidebarPanel.ResumeLayout(false);
            this.menuPanel.ResumeLayout(false);
            this.footerPanel.ResumeLayout(false);
            this.brandPanel.ResumeLayout(false);
            this.brandPanel.PerformLayout();
            this.logoBox.ResumeLayout(false);
            this.contentPanel.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)(this.pictureBox1)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.pictureBox2)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.pictureBox3)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.pictureBox4)).EndInit();
            this.ResumeLayout(false);

        }

        #endregion

        private System.Windows.Forms.PictureBox pictureBox1;
        private System.Windows.Forms.PictureBox pictureBox2;
        private System.Windows.Forms.PictureBox pictureBox3;
        private System.Windows.Forms.Panel panel1;
        private System.Windows.Forms.PictureBox pictureBox4;
    }
}
