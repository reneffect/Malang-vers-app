namespace dekstop
{
    partial class EbookControl
    {
        private System.ComponentModel.IContainer components = null;

        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        private void InitializeComponent()
        {
            this.pnlHeader = new System.Windows.Forms.Panel();
            this.lblBreadcrumb = new System.Windows.Forms.Label();
            this.lblTitle = new System.Windows.Forms.Label();
            this.lblSubtitle = new System.Windows.Forms.Label();
            this.pnlCard1 = new System.Windows.Forms.Panel();
            this.lblCard1Icon = new System.Windows.Forms.Label();
            this.lblCard1Title = new System.Windows.Forms.Label();
            this.lblCard1Val = new System.Windows.Forms.Label();
            this.pnlCard2 = new System.Windows.Forms.Panel();
            this.lblCard2Icon = new System.Windows.Forms.Label();
            this.lblCard2Title = new System.Windows.Forms.Label();
            this.lblCard2Val = new System.Windows.Forms.Label();
            this.pnlCard3 = new System.Windows.Forms.Panel();
            this.lblCard3Icon = new System.Windows.Forms.Label();
            this.lblCard3Title = new System.Windows.Forms.Label();
            this.lblCard3Val = new System.Windows.Forms.Label();
            this.pnlSearchBar = new System.Windows.Forms.Panel();
            this.txtSearch = new System.Windows.Forms.TextBox();
            this.btnSearch = new System.Windows.Forms.Button();
            this.pnlMainBody = new System.Windows.Forms.Panel();
            this.pnlTableContainer = new System.Windows.Forms.Panel();
            this.dgvKamus = new System.Windows.Forms.DataGridView();
            this.pnlTableHeader = new System.Windows.Forms.Panel();
            this.lblDataGridTitle = new System.Windows.Forms.Label();
            this.pnlPagination = new System.Windows.Forms.Panel();
            this.lblPageInfo = new System.Windows.Forms.Label();
            this.btnPageFirst = new System.Windows.Forms.Button();
            this.btnPagePrev = new System.Windows.Forms.Button();
            this.btnPage1 = new System.Windows.Forms.Button();
            this.btnPage2 = new System.Windows.Forms.Button();
            this.btnPage3 = new System.Windows.Forms.Button();
            this.btnPageNext = new System.Windows.Forms.Button();
            this.btnPageLast = new System.Windows.Forms.Button();
            this.pnlDialog = new System.Windows.Forms.Panel();
            this.pnlDialogBody = new System.Windows.Forms.Panel();
            this.grpInfoKamus = new System.Windows.Forms.GroupBox();
            this.lblEbookTitle = new System.Windows.Forms.Label();
            this.txtEbookTitle = new System.Windows.Forms.TextBox();
            this.lblCategory = new System.Windows.Forms.Label();
            this.cmbCategory = new System.Windows.Forms.ComboBox();
            this.lblWriter = new System.Windows.Forms.Label();
            this.txtWriter = new System.Windows.Forms.TextBox();
            this.lblPrice = new System.Windows.Forms.Label();
            this.lblPricePrefix = new System.Windows.Forms.Label();
            this.txtPrice = new System.Windows.Forms.TextBox();
            this.lblEntryEst = new System.Windows.Forms.Label();
            this.txtEntryEst = new System.Windows.Forms.TextBox();
            this.lblDesc = new System.Windows.Forms.Label();
            this.txtDesc = new System.Windows.Forms.TextBox();
            this.lblAccessStatus = new System.Windows.Forms.Label();
            this.cmbAccessStatus = new System.Windows.Forms.ComboBox();
            this.grpPdfConfig = new System.Windows.Forms.GroupBox();
            this.lblPdfSource = new System.Windows.Forms.Label();
            this.txtPdfPath = new System.Windows.Forms.TextBox();
            this.btnBrowsePdf = new System.Windows.Forms.Button();
            this.lblPdfStatus = new System.Windows.Forms.Label();
            this.chkEbookAktif = new System.Windows.Forms.CheckBox();
            this.pnlDialogHeader = new System.Windows.Forms.Panel();
            this.lblDialogTitle = new System.Windows.Forms.Label();
            this.btnCloseDialog = new System.Windows.Forms.Button();
            this.pnlDialogFooter = new System.Windows.Forms.Panel();
            this.btnBatal = new System.Windows.Forms.Button();
            this.btnSimpanData = new System.Windows.Forms.Button();
            this.pnlHeader.SuspendLayout();
            this.pnlCard1.SuspendLayout();
            this.pnlCard2.SuspendLayout();
            this.pnlCard3.SuspendLayout();
            this.pnlSearchBar.SuspendLayout();
            this.pnlMainBody.SuspendLayout();
            this.pnlTableContainer.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.dgvKamus)).BeginInit();
            this.pnlTableHeader.SuspendLayout();
            this.pnlPagination.SuspendLayout();
            this.pnlDialog.SuspendLayout();
            this.pnlDialogBody.SuspendLayout();
            this.grpInfoKamus.SuspendLayout();
            this.grpPdfConfig.SuspendLayout();
            this.pnlDialogHeader.SuspendLayout();
            this.pnlDialogFooter.SuspendLayout();
            this.SuspendLayout();
            // 
            // pnlHeader
            // 
            this.pnlHeader.BackColor = System.Drawing.Color.White;
            this.pnlHeader.Controls.Add(this.lblBreadcrumb);
            this.pnlHeader.Controls.Add(this.lblTitle);
            this.pnlHeader.Controls.Add(this.lblSubtitle);
            this.pnlHeader.Controls.Add(this.pnlCard1);
            this.pnlHeader.Controls.Add(this.pnlCard2);
            this.pnlHeader.Controls.Add(this.pnlCard3);
            this.pnlHeader.Dock = System.Windows.Forms.DockStyle.Top;
            this.pnlHeader.Location = new System.Drawing.Point(0, 0);
            this.pnlHeader.Name = "pnlHeader";
            this.pnlHeader.Size = new System.Drawing.Size(1160, 82);
            this.pnlHeader.TabIndex = 2;
            // 
            // lblBreadcrumb
            // 
            this.lblBreadcrumb.AutoSize = true;
            this.lblBreadcrumb.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.lblBreadcrumb.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(37)))), ((int)(((byte)(99)))), ((int)(((byte)(235)))));
            this.lblBreadcrumb.Location = new System.Drawing.Point(16, 8);
            this.lblBreadcrumb.Name = "lblBreadcrumb";
            this.lblBreadcrumb.Size = new System.Drawing.Size(217, 20);
            this.lblBreadcrumb.TabIndex = 0;
            this.lblBreadcrumb.Text = "> Kelola Kamus Boso Walikan";
            // 
            // lblTitle
            // 
            this.lblTitle.AutoSize = true;
            this.lblTitle.Font = new System.Drawing.Font("Segoe UI", 13.5F, System.Drawing.FontStyle.Bold);
            this.lblTitle.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(17)))), ((int)(((byte)(24)))), ((int)(((byte)(39)))));
            this.lblTitle.Location = new System.Drawing.Point(15, 25);
            this.lblTitle.Name = "lblTitle";
            this.lblTitle.Size = new System.Drawing.Size(664, 31);
            this.lblTitle.TabIndex = 1;
            this.lblTitle.Text = "Catalog & Vocabulary of Osob Kiwalan (Boso Walikan Malang)";
            // 
            // lblSubtitle
            // 
            this.lblSubtitle.AutoSize = true;
            this.lblSubtitle.Font = new System.Drawing.Font("Segoe UI", 8.5F);
            this.lblSubtitle.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(107)))), ((int)(((byte)(114)))), ((int)(((byte)(128)))));
            this.lblSubtitle.Location = new System.Drawing.Point(16, 52);
            this.lblSubtitle.Name = "lblSubtitle";
            this.lblSubtitle.Size = new System.Drawing.Size(708, 20);
            this.lblSubtitle.TabIndex = 2;
            this.lblSubtitle.Text = "List of Osob Kiwalan (Malang inverted language/Boso Walikan) vocabulary, dialects" +
    ", and verified PDF files";
            // 
            // pnlCard1
            // 
            this.pnlCard1.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.pnlCard1.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(241)))), ((int)(((byte)(245)))), ((int)(((byte)(249)))));
            this.pnlCard1.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.pnlCard1.Controls.Add(this.lblCard1Icon);
            this.pnlCard1.Controls.Add(this.lblCard1Title);
            this.pnlCard1.Controls.Add(this.lblCard1Val);
            this.pnlCard1.Location = new System.Drawing.Point(755, 10);
            this.pnlCard1.Name = "pnlCard1";
            this.pnlCard1.Size = new System.Drawing.Size(118, 52);
            this.pnlCard1.TabIndex = 3;
            // 
            // lblCard1Icon
            // 
            this.lblCard1Icon.Font = new System.Drawing.Font("Segoe UI", 12F);
            this.lblCard1Icon.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(37)))), ((int)(((byte)(99)))), ((int)(((byte)(235)))));
            this.lblCard1Icon.Location = new System.Drawing.Point(6, 12);
            this.lblCard1Icon.Name = "lblCard1Icon";
            this.lblCard1Icon.Size = new System.Drawing.Size(26, 26);
            this.lblCard1Icon.TabIndex = 0;
            this.lblCard1Icon.Text = "📖";
            // 
            // lblCard1Title
            // 
            this.lblCard1Title.Font = new System.Drawing.Font("Segoe UI", 7.5F);
            this.lblCard1Title.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(71)))), ((int)(((byte)(85)))), ((int)(((byte)(105)))));
            this.lblCard1Title.Location = new System.Drawing.Point(34, 7);
            this.lblCard1Title.Name = "lblCard1Title";
            this.lblCard1Title.Size = new System.Drawing.Size(78, 15);
            this.lblCard1Title.TabIndex = 1;
            this.lblCard1Title.Text = "Total Kamus";
            // 
            // lblCard1Val
            // 
            this.lblCard1Val.Font = new System.Drawing.Font("Segoe UI", 10F, System.Drawing.FontStyle.Bold);
            this.lblCard1Val.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.lblCard1Val.Location = new System.Drawing.Point(34, 23);
            this.lblCard1Val.Name = "lblCard1Val";
            this.lblCard1Val.Size = new System.Drawing.Size(78, 22);
            this.lblCard1Val.TabIndex = 2;
            this.lblCard1Val.Text = "0 Entri";
            // 
            // pnlCard2
            // 
            this.pnlCard2.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.pnlCard2.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(236)))), ((int)(((byte)(253)))), ((int)(((byte)(245)))));
            this.pnlCard2.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.pnlCard2.Controls.Add(this.lblCard2Icon);
            this.pnlCard2.Controls.Add(this.lblCard2Title);
            this.pnlCard2.Controls.Add(this.lblCard2Val);
            this.pnlCard2.Location = new System.Drawing.Point(880, 10);
            this.pnlCard2.Name = "pnlCard2";
            this.pnlCard2.Size = new System.Drawing.Size(136, 52);
            this.pnlCard2.TabIndex = 4;
            // 
            // lblCard2Icon
            // 
            this.lblCard2Icon.Font = new System.Drawing.Font("Segoe UI", 12F);
            this.lblCard2Icon.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(21)))), ((int)(((byte)(128)))), ((int)(((byte)(61)))));
            this.lblCard2Icon.Location = new System.Drawing.Point(6, 12);
            this.lblCard2Icon.Name = "lblCard2Icon";
            this.lblCard2Icon.Size = new System.Drawing.Size(26, 26);
            this.lblCard2Icon.TabIndex = 0;
            this.lblCard2Icon.Text = "💵";
            // 
            // lblCard2Title
            // 
            this.lblCard2Title.Font = new System.Drawing.Font("Segoe UI", 7.5F);
            this.lblCard2Title.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(22)))), ((int)(((byte)(101)))), ((int)(((byte)(52)))));
            this.lblCard2Title.Location = new System.Drawing.Point(34, 7);
            this.lblCard2Title.Name = "lblCard2Title";
            this.lblCard2Title.Size = new System.Drawing.Size(96, 15);
            this.lblCard2Title.TabIndex = 1;
            this.lblCard2Title.Text = "QRIS Terverifikasi";
            // 
            // lblCard2Val
            // 
            this.lblCard2Val.Font = new System.Drawing.Font("Segoe UI", 9.5F, System.Drawing.FontStyle.Bold);
            this.lblCard2Val.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(21)))), ((int)(((byte)(128)))), ((int)(((byte)(61)))));
            this.lblCard2Val.Location = new System.Drawing.Point(34, 23);
            this.lblCard2Val.Name = "lblCard2Val";
            this.lblCard2Val.Size = new System.Drawing.Size(98, 22);
            this.lblCard2Val.TabIndex = 2;
            this.lblCard2Val.Text = "Rp 0";
            // 
            // pnlCard3
            // 
            this.pnlCard3.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.pnlCard3.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(241)))), ((int)(((byte)(245)))), ((int)(((byte)(249)))));
            this.pnlCard3.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.pnlCard3.Controls.Add(this.lblCard3Icon);
            this.pnlCard3.Controls.Add(this.lblCard3Title);
            this.pnlCard3.Controls.Add(this.lblCard3Val);
            this.pnlCard3.Location = new System.Drawing.Point(1023, 10);
            this.pnlCard3.Name = "pnlCard3";
            this.pnlCard3.Size = new System.Drawing.Size(124, 52);
            this.pnlCard3.TabIndex = 5;
            // 
            // lblCard3Icon
            // 
            this.lblCard3Icon.Font = new System.Drawing.Font("Segoe UI", 12F);
            this.lblCard3Icon.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(71)))), ((int)(((byte)(85)))), ((int)(((byte)(105)))));
            this.lblCard3Icon.Location = new System.Drawing.Point(6, 12);
            this.lblCard3Icon.Name = "lblCard3Icon";
            this.lblCard3Icon.Size = new System.Drawing.Size(26, 26);
            this.lblCard3Icon.TabIndex = 0;
            this.lblCard3Icon.Text = "👤";
            // 
            // lblCard3Title
            // 
            this.lblCard3Title.Font = new System.Drawing.Font("Segoe UI", 7.5F);
            this.lblCard3Title.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(71)))), ((int)(((byte)(85)))), ((int)(((byte)(105)))));
            this.lblCard3Title.Location = new System.Drawing.Point(34, 7);
            this.lblCard3Title.Name = "lblCard3Title";
            this.lblCard3Title.Size = new System.Drawing.Size(84, 15);
            this.lblCard3Title.TabIndex = 1;
            this.lblCard3Title.Text = "Pelanggan Aktif";
            // 
            // lblCard3Val
            // 
            this.lblCard3Val.Font = new System.Drawing.Font("Segoe UI", 10F, System.Drawing.FontStyle.Bold);
            this.lblCard3Val.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.lblCard3Val.Location = new System.Drawing.Point(34, 23);
            this.lblCard3Val.Name = "lblCard3Val";
            this.lblCard3Val.Size = new System.Drawing.Size(84, 22);
            this.lblCard3Val.TabIndex = 2;
            this.lblCard3Val.Text = "0 User";
            // 
            // pnlSearchBar
            // 
            this.pnlSearchBar.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(248)))), ((int)(((byte)(250)))), ((int)(((byte)(252)))));
            this.pnlSearchBar.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.pnlSearchBar.Controls.Add(this.txtSearch);
            this.pnlSearchBar.Controls.Add(this.btnSearch);
            this.pnlSearchBar.Dock = System.Windows.Forms.DockStyle.Top;
            this.pnlSearchBar.Location = new System.Drawing.Point(0, 82);
            this.pnlSearchBar.Name = "pnlSearchBar";
            this.pnlSearchBar.Size = new System.Drawing.Size(1160, 52);
            this.pnlSearchBar.TabIndex = 1;
            // 
            // txtSearch
            // 
            this.txtSearch.Font = new System.Drawing.Font("Segoe UI", 9F);
            this.txtSearch.ForeColor = System.Drawing.Color.Gray;
            this.txtSearch.Location = new System.Drawing.Point(16, 12);
            this.txtSearch.Name = "txtSearch";
            this.txtSearch.Size = new System.Drawing.Size(240, 27);
            this.txtSearch.TabIndex = 0;
            this.txtSearch.Text = "Search for Titles / Words.";
            this.txtSearch.Enter += new System.EventHandler(this.txtSearch_Enter);
            this.txtSearch.Leave += new System.EventHandler(this.txtSearch_Leave);
            // 
            // btnSearch
            // 
            this.btnSearch.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(226)))), ((int)(((byte)(232)))), ((int)(((byte)(240)))));
            this.btnSearch.FlatAppearance.BorderColor = System.Drawing.Color.FromArgb(((int)(((byte)(203)))), ((int)(((byte)(213)))), ((int)(((byte)(225)))));
            this.btnSearch.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.btnSearch.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.btnSearch.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.btnSearch.Location = new System.Drawing.Point(256, 12);
            this.btnSearch.Name = "btnSearch";
            this.btnSearch.Size = new System.Drawing.Size(66, 26);
            this.btnSearch.TabIndex = 1;
            this.btnSearch.Text = "Search";
            this.btnSearch.UseVisualStyleBackColor = false;
            this.btnSearch.Click += new System.EventHandler(this.btnSearch_Click);
            // 
            // pnlMainBody
            // 
            this.pnlMainBody.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(241)))), ((int)(((byte)(245)))), ((int)(((byte)(249)))));
            this.pnlMainBody.Controls.Add(this.pnlTableContainer);
            this.pnlMainBody.Controls.Add(this.pnlDialog);
            this.pnlMainBody.Dock = System.Windows.Forms.DockStyle.Fill;
            this.pnlMainBody.Location = new System.Drawing.Point(0, 134);
            this.pnlMainBody.Name = "pnlMainBody";
            this.pnlMainBody.Padding = new System.Windows.Forms.Padding(12);
            this.pnlMainBody.Size = new System.Drawing.Size(1160, 746);
            this.pnlMainBody.TabIndex = 0;
            // 
            // pnlTableContainer
            // 
            this.pnlTableContainer.BackColor = System.Drawing.Color.White;
            this.pnlTableContainer.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.pnlTableContainer.Controls.Add(this.dgvKamus);
            this.pnlTableContainer.Controls.Add(this.pnlTableHeader);
            this.pnlTableContainer.Controls.Add(this.pnlPagination);
            this.pnlTableContainer.Dock = System.Windows.Forms.DockStyle.Fill;
            this.pnlTableContainer.Location = new System.Drawing.Point(12, 12);
            this.pnlTableContainer.Name = "pnlTableContainer";
            this.pnlTableContainer.Size = new System.Drawing.Size(706, 722);
            this.pnlTableContainer.TabIndex = 0;
            // 
            // dgvKamus
            // 
            this.dgvKamus.AllowUserToAddRows = false;
            this.dgvKamus.AllowUserToDeleteRows = false;
            this.dgvKamus.AllowUserToResizeRows = false;
            this.dgvKamus.AutoSizeColumnsMode = System.Windows.Forms.DataGridViewAutoSizeColumnsMode.Fill;
            this.dgvKamus.BackgroundColor = System.Drawing.Color.White;
            this.dgvKamus.BorderStyle = System.Windows.Forms.BorderStyle.None;
            this.dgvKamus.CellBorderStyle = System.Windows.Forms.DataGridViewCellBorderStyle.SingleHorizontal;
            this.dgvKamus.ColumnHeadersBorderStyle = System.Windows.Forms.DataGridViewHeaderBorderStyle.Single;
            this.dgvKamus.ColumnHeadersHeight = 36;
            this.dgvKamus.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.DisableResizing;
            this.dgvKamus.Dock = System.Windows.Forms.DockStyle.Fill;
            this.dgvKamus.EnableHeadersVisualStyles = false;
            this.dgvKamus.GridColor = System.Drawing.Color.FromArgb(((int)(((byte)(226)))), ((int)(((byte)(232)))), ((int)(((byte)(240)))));
            this.dgvKamus.Location = new System.Drawing.Point(0, 34);
            this.dgvKamus.MultiSelect = false;
            this.dgvKamus.Name = "dgvKamus";
            this.dgvKamus.RowHeadersVisible = false;
            this.dgvKamus.RowHeadersWidth = 51;
            this.dgvKamus.RowTemplate.Height = 52;
            this.dgvKamus.SelectionMode = System.Windows.Forms.DataGridViewSelectionMode.FullRowSelect;
            this.dgvKamus.Size = new System.Drawing.Size(704, 650);
            this.dgvKamus.TabIndex = 0;
            this.dgvKamus.CellClick += new System.Windows.Forms.DataGridViewCellEventHandler(this.dgvKamus_CellClick);
            this.dgvKamus.CellFormatting += new System.Windows.Forms.DataGridViewCellFormattingEventHandler(this.dgvKamus_CellFormatting);
            // 
            // pnlTableHeader
            // 
            this.pnlTableHeader.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(241)))), ((int)(((byte)(245)))), ((int)(((byte)(249)))));
            this.pnlTableHeader.Controls.Add(this.lblDataGridTitle);
            this.pnlTableHeader.Dock = System.Windows.Forms.DockStyle.Top;
            this.pnlTableHeader.Location = new System.Drawing.Point(0, 0);
            this.pnlTableHeader.Name = "pnlTableHeader";
            this.pnlTableHeader.Size = new System.Drawing.Size(704, 34);
            this.pnlTableHeader.TabIndex = 1;
            // 
            // lblDataGridTitle
            // 
            this.lblDataGridTitle.AutoSize = true;
            this.lblDataGridTitle.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.lblDataGridTitle.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.lblDataGridTitle.Location = new System.Drawing.Point(10, 9);
            this.lblDataGridTitle.Name = "lblDataGridTitle";
            this.lblDataGridTitle.Size = new System.Drawing.Size(236, 20);
            this.lblDataGridTitle.TabIndex = 0;
            this.lblDataGridTitle.Text = "🗄️ DataGrid: tbl_kamus_walikan";
            // 
            // pnlPagination
            // 
            this.pnlPagination.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(248)))), ((int)(((byte)(250)))), ((int)(((byte)(252)))));
            this.pnlPagination.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.pnlPagination.Controls.Add(this.lblPageInfo);
            this.pnlPagination.Controls.Add(this.btnPageFirst);
            this.pnlPagination.Controls.Add(this.btnPagePrev);
            this.pnlPagination.Controls.Add(this.btnPage1);
            this.pnlPagination.Controls.Add(this.btnPage2);
            this.pnlPagination.Controls.Add(this.btnPage3);
            this.pnlPagination.Controls.Add(this.btnPageNext);
            this.pnlPagination.Controls.Add(this.btnPageLast);
            this.pnlPagination.Dock = System.Windows.Forms.DockStyle.Bottom;
            this.pnlPagination.Location = new System.Drawing.Point(0, 684);
            this.pnlPagination.Name = "pnlPagination";
            this.pnlPagination.Size = new System.Drawing.Size(704, 36);
            this.pnlPagination.TabIndex = 2;
            // 
            // lblPageInfo
            // 
            this.lblPageInfo.AutoSize = true;
            this.lblPageInfo.Font = new System.Drawing.Font("Segoe UI", 8F);
            this.lblPageInfo.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(71)))), ((int)(((byte)(85)))), ((int)(((byte)(105)))));
            this.lblPageInfo.Location = new System.Drawing.Point(10, 10);
            this.lblPageInfo.Name = "lblPageInfo";
            this.lblPageInfo.Size = new System.Drawing.Size(298, 19);
            this.lblPageInfo.TabIndex = 0;
            this.lblPageInfo.Text = "Menampilkan 0 entri kamus   |   Terpilih: 0 baris";
            // 
            // btnPageFirst
            // 
            this.btnPageFirst.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.btnPageFirst.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.btnPageFirst.Location = new System.Drawing.Point(511, 6);
            this.btnPageFirst.Name = "btnPageFirst";
            this.btnPageFirst.Size = new System.Drawing.Size(26, 23);
            this.btnPageFirst.TabIndex = 1;
            this.btnPageFirst.Text = "<<";
            // 
            // btnPagePrev
            // 
            this.btnPagePrev.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.btnPagePrev.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.btnPagePrev.Location = new System.Drawing.Point(540, 6);
            this.btnPagePrev.Name = "btnPagePrev";
            this.btnPagePrev.Size = new System.Drawing.Size(24, 23);
            this.btnPagePrev.TabIndex = 2;
            this.btnPagePrev.Text = "<";
            // 
            // btnPage1
            // 
            this.btnPage1.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.btnPage1.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(37)))), ((int)(((byte)(99)))), ((int)(((byte)(235)))));
            this.btnPage1.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.btnPage1.ForeColor = System.Drawing.Color.White;
            this.btnPage1.Location = new System.Drawing.Point(567, 6);
            this.btnPage1.Name = "btnPage1";
            this.btnPage1.Size = new System.Drawing.Size(24, 23);
            this.btnPage1.TabIndex = 3;
            this.btnPage1.Text = "1";
            this.btnPage1.UseVisualStyleBackColor = false;
            // 
            // btnPage2
            // 
            this.btnPage2.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.btnPage2.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.btnPage2.Location = new System.Drawing.Point(594, 6);
            this.btnPage2.Name = "btnPage2";
            this.btnPage2.Size = new System.Drawing.Size(24, 23);
            this.btnPage2.TabIndex = 4;
            this.btnPage2.Text = "2";
            // 
            // btnPage3
            // 
            this.btnPage3.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.btnPage3.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.btnPage3.Location = new System.Drawing.Point(621, 6);
            this.btnPage3.Name = "btnPage3";
            this.btnPage3.Size = new System.Drawing.Size(24, 23);
            this.btnPage3.TabIndex = 5;
            this.btnPage3.Text = "3";
            // 
            // btnPageNext
            // 
            this.btnPageNext.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.btnPageNext.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.btnPageNext.Location = new System.Drawing.Point(648, 6);
            this.btnPageNext.Name = "btnPageNext";
            this.btnPageNext.Size = new System.Drawing.Size(24, 26);
            this.btnPageNext.TabIndex = 6;
            this.btnPageNext.Text = ">";
            // 
            // btnPageLast
            // 
            this.btnPageLast.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.btnPageLast.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.btnPageLast.Location = new System.Drawing.Point(675, 6);
            this.btnPageLast.Name = "btnPageLast";
            this.btnPageLast.Size = new System.Drawing.Size(26, 23);
            this.btnPageLast.TabIndex = 7;
            this.btnPageLast.Text = ">>";
            // 
            // pnlDialog
            // 
            this.pnlDialog.BackColor = System.Drawing.Color.White;
            this.pnlDialog.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.pnlDialog.Controls.Add(this.pnlDialogBody);
            this.pnlDialog.Controls.Add(this.pnlDialogHeader);
            this.pnlDialog.Controls.Add(this.pnlDialogFooter);
            this.pnlDialog.Dock = System.Windows.Forms.DockStyle.Right;
            this.pnlDialog.Location = new System.Drawing.Point(718, 12);
            this.pnlDialog.Name = "pnlDialog";
            this.pnlDialog.Size = new System.Drawing.Size(430, 722);
            this.pnlDialog.TabIndex = 1;
            // 
            // pnlDialogBody
            // 
            this.pnlDialogBody.AutoScroll = true;
            this.pnlDialogBody.Controls.Add(this.grpInfoKamus);
            this.pnlDialogBody.Controls.Add(this.grpPdfConfig);
            this.pnlDialogBody.Dock = System.Windows.Forms.DockStyle.Fill;
            this.pnlDialogBody.Location = new System.Drawing.Point(0, 36);
            this.pnlDialogBody.Name = "pnlDialogBody";
            this.pnlDialogBody.Size = new System.Drawing.Size(428, 638);
            this.pnlDialogBody.TabIndex = 0;
            // 
            // grpInfoKamus
            // 
            this.grpInfoKamus.Controls.Add(this.lblEbookTitle);
            this.grpInfoKamus.Controls.Add(this.txtEbookTitle);
            this.grpInfoKamus.Controls.Add(this.lblCategory);
            this.grpInfoKamus.Controls.Add(this.cmbCategory);
            this.grpInfoKamus.Controls.Add(this.lblWriter);
            this.grpInfoKamus.Controls.Add(this.txtWriter);
            this.grpInfoKamus.Controls.Add(this.lblPrice);
            this.grpInfoKamus.Controls.Add(this.lblPricePrefix);
            this.grpInfoKamus.Controls.Add(this.txtPrice);
            this.grpInfoKamus.Controls.Add(this.lblEntryEst);
            this.grpInfoKamus.Controls.Add(this.txtEntryEst);
            this.grpInfoKamus.Controls.Add(this.lblDesc);
            this.grpInfoKamus.Controls.Add(this.txtDesc);
            this.grpInfoKamus.Controls.Add(this.lblAccessStatus);
            this.grpInfoKamus.Controls.Add(this.cmbAccessStatus);
            this.grpInfoKamus.Font = new System.Drawing.Font("Segoe UI", 8F, System.Drawing.FontStyle.Bold);
            this.grpInfoKamus.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(71)))), ((int)(((byte)(85)))), ((int)(((byte)(105)))));
            this.grpInfoKamus.Location = new System.Drawing.Point(14, 12);
            this.grpInfoKamus.Name = "grpInfoKamus";
            this.grpInfoKamus.Size = new System.Drawing.Size(398, 345);
            this.grpInfoKamus.TabIndex = 0;
            this.grpInfoKamus.TabStop = false;
            this.grpInfoKamus.Text = "INFORMASI KAMUS";
            // 
            // lblEbookTitle
            // 
            this.lblEbookTitle.AutoSize = true;
            this.lblEbookTitle.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.lblEbookTitle.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.lblEbookTitle.Location = new System.Drawing.Point(12, 22);
            this.lblEbookTitle.Name = "lblEbookTitle";
            this.lblEbookTitle.Size = new System.Drawing.Size(98, 20);
            this.lblEbookTitle.TabIndex = 0;
            this.lblEbookTitle.Text = "E-Book Title:";
            // 
            // txtEbookTitle
            // 
            this.txtEbookTitle.Font = new System.Drawing.Font("Segoe UI", 9F);
            this.txtEbookTitle.Location = new System.Drawing.Point(12, 42);
            this.txtEbookTitle.Name = "txtEbookTitle";
            this.txtEbookTitle.Size = new System.Drawing.Size(372, 27);
            this.txtEbookTitle.TabIndex = 1;
            // 
            // lblCategory
            // 
            this.lblCategory.AutoSize = true;
            this.lblCategory.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.lblCategory.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.lblCategory.Location = new System.Drawing.Point(12, 76);
            this.lblCategory.Name = "lblCategory";
            this.lblCategory.Size = new System.Drawing.Size(117, 20);
            this.lblCategory.TabIndex = 2;
            this.lblCategory.Text = "Category Level:";
            // 
            // cmbCategory
            // 
            this.cmbCategory.DropDownStyle = System.Windows.Forms.ComboBoxStyle.DropDownList;
            this.cmbCategory.Font = new System.Drawing.Font("Segoe UI", 9F);
            this.cmbCategory.Items.AddRange(new object[] {
            "Boso Walikan Kasual / Gaul (Aremanian)",
            "Boso Walikan Klasik / Sejarah",
            "Slang & Istilah Komunitas Malang",
            "Kamus Percakapan Sehari-hari"});
            this.cmbCategory.Location = new System.Drawing.Point(12, 96);
            this.cmbCategory.Name = "cmbCategory";
            this.cmbCategory.Size = new System.Drawing.Size(372, 28);
            this.cmbCategory.TabIndex = 3;
            // 
            // lblWriter
            // 
            this.lblWriter.AutoSize = true;
            this.lblWriter.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.lblWriter.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.lblWriter.Location = new System.Drawing.Point(12, 130);
            this.lblWriter.Name = "lblWriter";
            this.lblWriter.Size = new System.Drawing.Size(101, 20);
            this.lblWriter.TabIndex = 4;
            this.lblWriter.Text = "Writer name:";
            // 
            // txtWriter
            // 
            this.txtWriter.Font = new System.Drawing.Font("Segoe UI", 9F);
            this.txtWriter.Location = new System.Drawing.Point(12, 150);
            this.txtWriter.Name = "txtWriter";
            this.txtWriter.Size = new System.Drawing.Size(372, 27);
            this.txtWriter.TabIndex = 5;
            // 
            // lblPrice
            // 
            this.lblPrice.AutoSize = true;
            this.lblPrice.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.lblPrice.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.lblPrice.Location = new System.Drawing.Point(12, 184);
            this.lblPrice.Name = "lblPrice";
            this.lblPrice.Size = new System.Drawing.Size(94, 20);
            this.lblPrice.TabIndex = 6;
            this.lblPrice.Text = "Access Price";
            // 
            // lblPricePrefix
            // 
            this.lblPricePrefix.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(248)))), ((int)(((byte)(250)))), ((int)(((byte)(252)))));
            this.lblPricePrefix.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.lblPricePrefix.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.lblPricePrefix.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.lblPricePrefix.Location = new System.Drawing.Point(12, 204);
            this.lblPricePrefix.Name = "lblPricePrefix";
            this.lblPricePrefix.Size = new System.Drawing.Size(32, 25);
            this.lblPricePrefix.TabIndex = 7;
            this.lblPricePrefix.Text = "Rp";
            this.lblPricePrefix.TextAlign = System.Drawing.ContentAlignment.MiddleCenter;
            // 
            // txtPrice
            // 
            this.txtPrice.Font = new System.Drawing.Font("Segoe UI", 9F, System.Drawing.FontStyle.Bold);
            this.txtPrice.Location = new System.Drawing.Point(44, 204);
            this.txtPrice.Name = "txtPrice";
            this.txtPrice.Size = new System.Drawing.Size(148, 27);
            this.txtPrice.TabIndex = 8;
            this.txtPrice.Text = "0";
            this.txtPrice.TextAlign = System.Windows.Forms.HorizontalAlignment.Right;
            // 
            // lblEntryEst
            // 
            this.lblEntryEst.AutoSize = true;
            this.lblEntryEst.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.lblEntryEst.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.lblEntryEst.Location = new System.Drawing.Point(202, 184);
            this.lblEntryEst.Name = "lblEntryEst";
            this.lblEntryEst.Size = new System.Drawing.Size(116, 20);
            this.lblEntryEst.TabIndex = 9;
            this.lblEntryEst.Text = "Entry Estimate:";
            // 
            // txtEntryEst
            // 
            this.txtEntryEst.Font = new System.Drawing.Font("Segoe UI", 9F);
            this.txtEntryEst.Location = new System.Drawing.Point(202, 204);
            this.txtEntryEst.Name = "txtEntryEst";
            this.txtEntryEst.Size = new System.Drawing.Size(182, 27);
            this.txtEntryEst.TabIndex = 10;
            this.txtEntryEst.Text = "0";
            this.txtEntryEst.TextAlign = System.Windows.Forms.HorizontalAlignment.Right;
            // 
            // lblDesc
            // 
            this.lblDesc.AutoSize = true;
            this.lblDesc.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.lblDesc.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.lblDesc.Location = new System.Drawing.Point(12, 292);
            this.lblDesc.Name = "lblDesc";
            this.lblDesc.Size = new System.Drawing.Size(208, 20);
            this.lblDesc.TabIndex = 11;
            this.lblDesc.Text = "Brief Dictionary Description:";
            // 
            // txtDesc
            // 
            this.txtDesc.Font = new System.Drawing.Font("Segoe UI", 8.5F);
            this.txtDesc.Location = new System.Drawing.Point(12, 312);
            this.txtDesc.Multiline = true;
            this.txtDesc.Name = "txtDesc";
            this.txtDesc.Size = new System.Drawing.Size(372, 26);
            this.txtDesc.TabIndex = 12;
            this.lblAccessStatus.AutoSize = true;
            this.lblAccessStatus.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.lblAccessStatus.ForeColor = System.Drawing.Color.FromArgb(30, 41, 59);
            this.lblAccessStatus.Location = new System.Drawing.Point(12, 238);
            this.lblAccessStatus.Name = "lblAccessStatus";
            this.lblAccessStatus.Size = new System.Drawing.Size(110, 20);
            this.lblAccessStatus.TabIndex = 13;
            this.lblAccessStatus.Text = "Access Status:";
            this.cmbAccessStatus.DropDownStyle = System.Windows.Forms.ComboBoxStyle.DropDownList;
            this.cmbAccessStatus.Font = new System.Drawing.Font("Segoe UI", 9F);
            this.cmbAccessStatus.Items.AddRange(new object[] { "Free / Premium", "Premium Only", "Free Trial" });
            this.cmbAccessStatus.Location = new System.Drawing.Point(12, 258);
            this.cmbAccessStatus.Name = "cmbAccessStatus";
            this.cmbAccessStatus.Size = new System.Drawing.Size(372, 28);
            this.cmbAccessStatus.TabIndex = 14;
            // 
            // grpPdfConfig
            // 
            this.grpPdfConfig.Controls.Add(this.lblPdfSource);
            this.grpPdfConfig.Controls.Add(this.txtPdfPath);
            this.grpPdfConfig.Controls.Add(this.btnBrowsePdf);
            this.grpPdfConfig.Controls.Add(this.lblPdfStatus);
            this.grpPdfConfig.Controls.Add(this.chkEbookAktif);
            this.grpPdfConfig.Font = new System.Drawing.Font("Segoe UI", 8F, System.Drawing.FontStyle.Bold);
            this.grpPdfConfig.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(71)))), ((int)(((byte)(85)))), ((int)(((byte)(105)))));
            this.grpPdfConfig.Location = new System.Drawing.Point(14, 368);
            this.grpPdfConfig.Name = "grpPdfConfig";
            this.grpPdfConfig.Size = new System.Drawing.Size(398, 145);
            this.grpPdfConfig.TabIndex = 1;
            this.grpPdfConfig.TabStop = false;
            this.grpPdfConfig.Text = "PDF FILE & E-BOOK STATUS";
            // 
            // lblPdfSource
            // 
            this.lblPdfSource.AutoSize = true;
            this.lblPdfSource.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.lblPdfSource.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.lblPdfSource.Location = new System.Drawing.Point(12, 24);
            this.lblPdfSource.Name = "lblPdfSource";
            this.lblPdfSource.Size = new System.Drawing.Size(214, 20);
            this.lblPdfSource.TabIndex = 0;
            this.lblPdfSource.Text = "Select PDF Source Document:";
            // 
            // txtPdfPath
            // 
            this.txtPdfPath.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(248)))), ((int)(((byte)(250)))), ((int)(((byte)(252)))));
            this.txtPdfPath.Font = new System.Drawing.Font("Segoe UI", 8.5F);
            this.txtPdfPath.Location = new System.Drawing.Point(12, 44);
            this.txtPdfPath.Name = "txtPdfPath";
            this.txtPdfPath.ReadOnly = true;
            this.txtPdfPath.Size = new System.Drawing.Size(284, 26);
            this.txtPdfPath.TabIndex = 1;
            // 
            // btnBrowsePdf
            // 
            this.btnBrowsePdf.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(226)))), ((int)(((byte)(232)))), ((int)(((byte)(240)))));
            this.btnBrowsePdf.FlatAppearance.BorderColor = System.Drawing.Color.FromArgb(((int)(((byte)(203)))), ((int)(((byte)(213)))), ((int)(((byte)(225)))));
            this.btnBrowsePdf.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.btnBrowsePdf.Font = new System.Drawing.Font("Segoe UI", 8F, System.Drawing.FontStyle.Bold);
            this.btnBrowsePdf.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.btnBrowsePdf.Location = new System.Drawing.Point(301, 44);
            this.btnBrowsePdf.Name = "btnBrowsePdf";
            this.btnBrowsePdf.Size = new System.Drawing.Size(84, 37);
            this.btnBrowsePdf.TabIndex = 2;
            this.btnBrowsePdf.Text = "📁 Telusuri...";
            this.btnBrowsePdf.UseVisualStyleBackColor = false;
            this.btnBrowsePdf.Click += new System.EventHandler(this.btnBrowsePdf_Click);
            // 
            // lblPdfStatus
            // 
            this.lblPdfStatus.AutoSize = true;
            this.lblPdfStatus.Font = new System.Drawing.Font("Segoe UI", 7.5F);
            this.lblPdfStatus.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(100)))), ((int)(((byte)(116)))), ((int)(((byte)(139)))));
            this.lblPdfStatus.Location = new System.Drawing.Point(12, 74);
            this.lblPdfStatus.Name = "lblPdfStatus";
            this.lblPdfStatus.Size = new System.Drawing.Size(241, 17);
            this.lblPdfStatus.TabIndex = 3;
            this.lblPdfStatus.Text = "Ukuran file: - (Belum ada file PDF dipilih)";
            // 
            // chkEbookAktif - satu-satunya flag status yang tersedia pada ERD
            this.chkEbookAktif.AutoSize = true;
            this.chkEbookAktif.Checked = true;
            this.chkEbookAktif.CheckState = System.Windows.Forms.CheckState.Checked;
            this.chkEbookAktif.Font = new System.Drawing.Font("Segoe UI", 8.5F);
            this.chkEbookAktif.ForeColor = System.Drawing.Color.FromArgb(30, 41, 59);
            this.chkEbookAktif.Location = new System.Drawing.Point(12, 102);
            this.chkEbookAktif.Name = "chkEbookAktif";
            this.chkEbookAktif.Size = new System.Drawing.Size(180, 24);
            this.chkEbookAktif.TabIndex = 4;
            this.chkEbookAktif.Text = "E-Book Aktif";
            // 
            // pnlDialogHeader
            // 
            this.pnlDialogHeader.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.pnlDialogHeader.Controls.Add(this.lblDialogTitle);
            this.pnlDialogHeader.Controls.Add(this.btnCloseDialog);
            this.pnlDialogHeader.Dock = System.Windows.Forms.DockStyle.Top;
            this.pnlDialogHeader.Location = new System.Drawing.Point(0, 0);
            this.pnlDialogHeader.Name = "pnlDialogHeader";
            this.pnlDialogHeader.Size = new System.Drawing.Size(428, 36);
            this.pnlDialogHeader.TabIndex = 1;
            // 
            // lblDialogTitle
            // 
            this.lblDialogTitle.AutoSize = true;
            this.lblDialogTitle.Font = new System.Drawing.Font("Segoe UI", 9.5F, System.Drawing.FontStyle.Bold);
            this.lblDialogTitle.ForeColor = System.Drawing.Color.White;
            this.lblDialogTitle.Location = new System.Drawing.Point(12, 9);
            this.lblDialogTitle.Name = "lblDialogTitle";
            this.lblDialogTitle.Size = new System.Drawing.Size(353, 21);
            this.lblDialogTitle.TabIndex = 0;
            this.lblDialogTitle.Text = "Dialog: [Tambah Kamus Baru - Boso Walikan]";
            // 
            // btnCloseDialog
            // 
            this.btnCloseDialog.FlatAppearance.BorderSize = 0;
            this.btnCloseDialog.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.btnCloseDialog.Font = new System.Drawing.Font("Segoe UI", 9F);
            this.btnCloseDialog.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(203)))), ((int)(((byte)(213)))), ((int)(((byte)(225)))));
            this.btnCloseDialog.Location = new System.Drawing.Point(394, 4);
            this.btnCloseDialog.Name = "btnCloseDialog";
            this.btnCloseDialog.Size = new System.Drawing.Size(28, 28);
            this.btnCloseDialog.TabIndex = 1;
            this.btnCloseDialog.Text = "✕";
            this.btnCloseDialog.Click += new System.EventHandler(this.btnBatal_Click);
            // 
            // pnlDialogFooter
            // 
            this.pnlDialogFooter.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(248)))), ((int)(((byte)(250)))), ((int)(((byte)(252)))));
            this.pnlDialogFooter.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.pnlDialogFooter.Controls.Add(this.btnBatal);
            this.pnlDialogFooter.Controls.Add(this.btnSimpanData);
            this.pnlDialogFooter.Dock = System.Windows.Forms.DockStyle.Bottom;
            this.pnlDialogFooter.Location = new System.Drawing.Point(0, 674);
            this.pnlDialogFooter.Name = "pnlDialogFooter";
            this.pnlDialogFooter.Size = new System.Drawing.Size(428, 46);
            this.pnlDialogFooter.TabIndex = 2;
            // 
            // btnBatal
            // 
            this.btnBatal.BackColor = System.Drawing.Color.White;
            this.btnBatal.FlatAppearance.BorderColor = System.Drawing.Color.FromArgb(((int)(((byte)(203)))), ((int)(((byte)(213)))), ((int)(((byte)(225)))));
            this.btnBatal.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.btnBatal.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.btnBatal.Location = new System.Drawing.Point(242, 8);
            this.btnBatal.Name = "btnBatal";
            this.btnBatal.Size = new System.Drawing.Size(56, 28);
            this.btnBatal.TabIndex = 0;
            this.btnBatal.Text = "Batal";
            this.btnBatal.UseVisualStyleBackColor = false;
            this.btnBatal.Click += new System.EventHandler(this.btnBatal_Click);
            // 
            // btnSimpanData
            // 
            this.btnSimpanData.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(37)))), ((int)(((byte)(99)))), ((int)(((byte)(235)))));
            this.btnSimpanData.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.btnSimpanData.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.btnSimpanData.ForeColor = System.Drawing.Color.White;
            this.btnSimpanData.Location = new System.Drawing.Point(304, 8);
            this.btnSimpanData.Name = "btnSimpanData";
            this.btnSimpanData.Size = new System.Drawing.Size(110, 28);
            this.btnSimpanData.TabIndex = 1;
            this.btnSimpanData.Text = "💾 Simpan Data";
            this.btnSimpanData.UseVisualStyleBackColor = false;
            this.btnSimpanData.Click += new System.EventHandler(this.btnSimpanData_Click);
            // 
            // EbookControl
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(8F, 20F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.BackColor = System.Drawing.Color.White;
            this.Controls.Add(this.pnlMainBody);
            this.Controls.Add(this.pnlSearchBar);
            this.Controls.Add(this.pnlHeader);
            this.Font = new System.Drawing.Font("Segoe UI", 9F);
            this.Name = "EbookControl";
            this.Size = new System.Drawing.Size(1160, 880);
            this.pnlHeader.ResumeLayout(false);
            this.pnlHeader.PerformLayout();
            this.pnlCard1.ResumeLayout(false);
            this.pnlCard2.ResumeLayout(false);
            this.pnlCard3.ResumeLayout(false);
            this.pnlSearchBar.ResumeLayout(false);
            this.pnlSearchBar.PerformLayout();
            this.pnlMainBody.ResumeLayout(false);
            this.pnlTableContainer.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)(this.dgvKamus)).EndInit();
            this.pnlTableHeader.ResumeLayout(false);
            this.pnlTableHeader.PerformLayout();
            this.pnlPagination.ResumeLayout(false);
            this.pnlPagination.PerformLayout();
            this.pnlDialog.ResumeLayout(false);
            this.pnlDialogBody.ResumeLayout(false);
            this.grpInfoKamus.ResumeLayout(false);
            this.grpInfoKamus.PerformLayout();
            this.grpPdfConfig.ResumeLayout(false);
            this.grpPdfConfig.PerformLayout();
            this.pnlDialogHeader.ResumeLayout(false);
            this.pnlDialogHeader.PerformLayout();
            this.pnlDialogFooter.ResumeLayout(false);
            this.ResumeLayout(false);

        }

        private System.Windows.Forms.Panel pnlHeader;
        private System.Windows.Forms.Label lblBreadcrumb;
        private System.Windows.Forms.Label lblTitle;
        private System.Windows.Forms.Label lblSubtitle;
        private System.Windows.Forms.Panel pnlCard1;
        private System.Windows.Forms.Label lblCard1Icon;
        private System.Windows.Forms.Label lblCard1Title;
        private System.Windows.Forms.Label lblCard1Val;
        private System.Windows.Forms.Panel pnlCard2;
        private System.Windows.Forms.Label lblCard2Icon;
        private System.Windows.Forms.Label lblCard2Title;
        private System.Windows.Forms.Label lblCard2Val;
        private System.Windows.Forms.Panel pnlCard3;
        private System.Windows.Forms.Label lblCard3Icon;
        private System.Windows.Forms.Label lblCard3Title;
        private System.Windows.Forms.Label lblCard3Val;

        private System.Windows.Forms.Panel pnlSearchBar;
        private System.Windows.Forms.TextBox txtSearch;
        private System.Windows.Forms.Button btnSearch;

        private System.Windows.Forms.Panel pnlMainBody;
        private System.Windows.Forms.Panel pnlTableContainer;
        private System.Windows.Forms.Panel pnlTableHeader;
        private System.Windows.Forms.Label lblDataGridTitle;
        private System.Windows.Forms.DataGridView dgvKamus;
        private System.Windows.Forms.Panel pnlPagination;
        private System.Windows.Forms.Label lblPageInfo;
        private System.Windows.Forms.Button btnPageFirst;
        private System.Windows.Forms.Button btnPagePrev;
        private System.Windows.Forms.Button btnPage1;
        private System.Windows.Forms.Button btnPage2;
        private System.Windows.Forms.Button btnPage3;
        private System.Windows.Forms.Button btnPageNext;
        private System.Windows.Forms.Button btnPageLast;

        private System.Windows.Forms.Panel pnlDialog;
        private System.Windows.Forms.Panel pnlDialogHeader;
        private System.Windows.Forms.Label lblDialogTitle;
        private System.Windows.Forms.Button btnCloseDialog;
        private System.Windows.Forms.Panel pnlDialogBody;
        private System.Windows.Forms.GroupBox grpInfoKamus;
        private System.Windows.Forms.Label lblEbookTitle;
        private System.Windows.Forms.TextBox txtEbookTitle;
        private System.Windows.Forms.Label lblCategory;
        private System.Windows.Forms.ComboBox cmbCategory;
        private System.Windows.Forms.Label lblWriter;
        private System.Windows.Forms.TextBox txtWriter;
        private System.Windows.Forms.Label lblPrice;
        private System.Windows.Forms.Label lblPricePrefix;
        private System.Windows.Forms.TextBox txtPrice;
        private System.Windows.Forms.Label lblEntryEst;
        private System.Windows.Forms.TextBox txtEntryEst;
        private System.Windows.Forms.Label lblDesc;
        private System.Windows.Forms.TextBox txtDesc;
        private System.Windows.Forms.Label lblAccessStatus;
        private System.Windows.Forms.ComboBox cmbAccessStatus;

        private System.Windows.Forms.GroupBox grpPdfConfig;
        private System.Windows.Forms.Label lblPdfSource;
        private System.Windows.Forms.TextBox txtPdfPath;
        private System.Windows.Forms.Button btnBrowsePdf;
        private System.Windows.Forms.Label lblPdfStatus;
        private System.Windows.Forms.CheckBox chkEbookAktif;

        private System.Windows.Forms.Panel pnlDialogFooter;
        private System.Windows.Forms.Button btnBatal;
        private System.Windows.Forms.Button btnSimpanData;
    }
}