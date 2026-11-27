namespace dekstop
{
    partial class DiscountControl
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
            this.lblCard1Title = new System.Windows.Forms.Label();
            this.lblCard1Val = new System.Windows.Forms.Label();
            this.pnlCard2 = new System.Windows.Forms.Panel();
            this.lblCard2Title = new System.Windows.Forms.Label();
            this.lblCard2Val = new System.Windows.Forms.Label();
            this.pnlCard3 = new System.Windows.Forms.Panel();
            this.lblCard3Title = new System.Windows.Forms.Label();
            this.lblCard3Val = new System.Windows.Forms.Label();
            this.pnlSearchBar = new System.Windows.Forms.Panel();
            this.txtSearch = new System.Windows.Forms.TextBox();
            this.btnSearch = new System.Windows.Forms.Button();
            this.pnlMainBody = new System.Windows.Forms.Panel();
            this.pnlTableContainer = new System.Windows.Forms.Panel();
            this.dgvDiskon = new System.Windows.Forms.DataGridView();
            this.pnlTableHeader = new System.Windows.Forms.Panel();
            this.lblDataSet = new System.Windows.Forms.Label();
            this.pnlPagination = new System.Windows.Forms.Panel();
            this.lblPageInfo = new System.Windows.Forms.Label();
            this.btnPageFirst = new System.Windows.Forms.Button();
            this.btnPagePrev = new System.Windows.Forms.Button();
            this.btnPage1 = new System.Windows.Forms.Button();
            this.btnPageNext = new System.Windows.Forms.Button();
            this.btnPageLast = new System.Windows.Forms.Button();
            this.pnlDialog = new System.Windows.Forms.Panel();
            this.pnlDialogBody = new System.Windows.Forms.Panel();
            this.lblKode = new System.Windows.Forms.Label();
            this.txtKode = new System.Windows.Forms.TextBox();
            this.lblTipe = new System.Windows.Forms.Label();
            this.cmbTipe = new System.Windows.Forms.ComboBox();
            this.lblNilai = new System.Windows.Forms.Label();
            this.txtNilai = new System.Windows.Forms.TextBox();
            this.lblSuffix = new System.Windows.Forms.Label();
            this.lblNilaiHint = new System.Windows.Forms.Label();
            this.lblMinBeli = new System.Windows.Forms.Label();
            this.txtMinBeli = new System.Windows.Forms.TextBox();
            this.lblMasaBerlaku = new System.Windows.Forms.Label();
            this.dtpMasaBerlaku = new System.Windows.Forms.DateTimePicker();
            this.dtpJamBerlaku = new System.Windows.Forms.DateTimePicker();
            this.grpSyarat = new System.Windows.Forms.GroupBox();
            this.chkAktif = new System.Windows.Forms.CheckBox();
            this.lblCatatan = new System.Windows.Forms.Label();
            this.txtCatatan = new System.Windows.Forms.TextBox();
            this.pnlDialogHeader = new System.Windows.Forms.Panel();
            this.lblDialogTitle = new System.Windows.Forms.Label();
            this.btnCloseDialog = new System.Windows.Forms.Button();
            this.pnlDialogFooter = new System.Windows.Forms.Panel();
            this.btnBatal = new System.Windows.Forms.Button();
            this.btnHapusDiskon = new System.Windows.Forms.Button();
            this.btnSimpanDiskon = new System.Windows.Forms.Button();
            this.pnlHeader.SuspendLayout();
            this.pnlCard1.SuspendLayout();
            this.pnlCard2.SuspendLayout();
            this.pnlCard3.SuspendLayout();
            this.pnlSearchBar.SuspendLayout();
            this.pnlMainBody.SuspendLayout();
            this.pnlTableContainer.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.dgvDiskon)).BeginInit();
            this.pnlTableHeader.SuspendLayout();
            this.pnlPagination.SuspendLayout();
            this.pnlDialog.SuspendLayout();
            this.pnlDialogBody.SuspendLayout();
            this.grpSyarat.SuspendLayout();
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
            this.lblBreadcrumb.Size = new System.Drawing.Size(146, 20);
            this.lblBreadcrumb.TabIndex = 0;
            this.lblBreadcrumb.Text = "> Manage Discount";
            // 
            // lblTitle
            // 
            this.lblTitle.AutoSize = true;
            this.lblTitle.Font = new System.Drawing.Font("Segoe UI", 13.5F, System.Drawing.FontStyle.Bold);
            this.lblTitle.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(17)))), ((int)(((byte)(24)))), ((int)(((byte)(39)))));
            this.lblTitle.Location = new System.Drawing.Point(15, 25);
            this.lblTitle.Name = "lblTitle";
            this.lblTitle.Size = new System.Drawing.Size(477, 31);
            this.lblTitle.TabIndex = 1;
            this.lblTitle.Text = "Dictionary Discount Settings & Management";
            // 
            // lblSubtitle
            // 
            this.lblSubtitle.AutoSize = true;
            this.lblSubtitle.Font = new System.Drawing.Font("Segoe UI", 8.5F);
            this.lblSubtitle.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(107)))), ((int)(((byte)(114)))), ((int)(((byte)(128)))));
            this.lblSubtitle.Location = new System.Drawing.Point(16, 56);
            this.lblSubtitle.Name = "lblSubtitle";
            this.lblSubtitle.Size = new System.Drawing.Size(825, 20);
            this.lblSubtitle.TabIndex = 2;
            this.lblSubtitle.Text = "Manage discount vouchers, minimum purchase, validity period, and activation status.";
            // 
            // pnlCard1
            // 
            this.pnlCard1.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.pnlCard1.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(241)))), ((int)(((byte)(245)))), ((int)(((byte)(249)))));
            this.pnlCard1.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.pnlCard1.Controls.Add(this.lblCard1Title);
            this.pnlCard1.Controls.Add(this.lblCard1Val);
            this.pnlCard1.Location = new System.Drawing.Point(755, 10);
            this.pnlCard1.Name = "pnlCard1";
            this.pnlCard1.Size = new System.Drawing.Size(115, 52);
            this.pnlCard1.TabIndex = 3;
            // 
            // lblCard1Title
            // 
            this.lblCard1Title.Font = new System.Drawing.Font("Segoe UI", 7.5F);
            this.lblCard1Title.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(71)))), ((int)(((byte)(85)))), ((int)(((byte)(105)))));
            this.lblCard1Title.Location = new System.Drawing.Point(4, 6);
            this.lblCard1Title.Name = "lblCard1Title";
            this.lblCard1Title.Size = new System.Drawing.Size(105, 15);
            this.lblCard1Title.TabIndex = 0;
            this.lblCard1Title.Text = "Diskon Aktif";
            this.lblCard1Title.TextAlign = System.Drawing.ContentAlignment.MiddleRight;
            // 
            // lblCard1Val
            // 
            this.lblCard1Val.Font = new System.Drawing.Font("Segoe UI", 10.5F, System.Drawing.FontStyle.Bold);
            this.lblCard1Val.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(37)))), ((int)(((byte)(99)))), ((int)(((byte)(235)))));
            this.lblCard1Val.Location = new System.Drawing.Point(4, 23);
            this.lblCard1Val.Name = "lblCard1Val";
            this.lblCard1Val.Size = new System.Drawing.Size(105, 22);
            this.lblCard1Val.TabIndex = 1;
            this.lblCard1Val.Text = "6 Voucher";
            this.lblCard1Val.TextAlign = System.Drawing.ContentAlignment.MiddleRight;
            // 
            // pnlCard2
            // 
            this.pnlCard2.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.pnlCard2.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(241)))), ((int)(((byte)(245)))), ((int)(((byte)(249)))));
            this.pnlCard2.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.pnlCard2.Controls.Add(this.lblCard2Title);
            this.pnlCard2.Controls.Add(this.lblCard2Val);
            this.pnlCard2.Location = new System.Drawing.Point(878, 10);
            this.pnlCard2.Name = "pnlCard2";
            this.pnlCard2.Size = new System.Drawing.Size(128, 52);
            this.pnlCard2.TabIndex = 4;
            // 
            // lblCard2Title
            // 
            this.lblCard2Title.Font = new System.Drawing.Font("Segoe UI", 7.5F);
            this.lblCard2Title.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(71)))), ((int)(((byte)(85)))), ((int)(((byte)(105)))));
            this.lblCard2Title.Location = new System.Drawing.Point(4, 6);
            this.lblCard2Title.Name = "lblCard2Title";
            this.lblCard2Title.Size = new System.Drawing.Size(118, 15);
            this.lblCard2Title.TabIndex = 0;
            this.lblCard2Title.Text = "Total Voucher";
            this.lblCard2Title.TextAlign = System.Drawing.ContentAlignment.MiddleRight;
            // 
            // lblCard2Val
            // 
            this.lblCard2Val.Font = new System.Drawing.Font("Segoe UI", 10.5F, System.Drawing.FontStyle.Bold);
            this.lblCard2Val.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.lblCard2Val.Location = new System.Drawing.Point(4, 23);
            this.lblCard2Val.Name = "lblCard2Val";
            this.lblCard2Val.Size = new System.Drawing.Size(118, 22);
            this.lblCard2Val.TabIndex = 1;
            this.lblCard2Val.Text = "348 Pengguna";
            this.lblCard2Val.TextAlign = System.Drawing.ContentAlignment.MiddleRight;
            // 
            // pnlCard3
            // 
            this.pnlCard3.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.pnlCard3.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(236)))), ((int)(((byte)(253)))), ((int)(((byte)(245)))));
            this.pnlCard3.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.pnlCard3.Controls.Add(this.lblCard3Title);
            this.pnlCard3.Controls.Add(this.lblCard3Val);
            this.pnlCard3.Location = new System.Drawing.Point(1014, 10);
            this.pnlCard3.Name = "pnlCard3";
            this.pnlCard3.Size = new System.Drawing.Size(132, 52);
            this.pnlCard3.TabIndex = 5;
            // 
            // lblCard3Title
            // 
            this.lblCard3Title.Font = new System.Drawing.Font("Segoe UI", 7.5F);
            this.lblCard3Title.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(22)))), ((int)(((byte)(101)))), ((int)(((byte)(52)))));
            this.lblCard3Title.Location = new System.Drawing.Point(4, 6);
            this.lblCard3Title.Name = "lblCard3Title";
            this.lblCard3Title.Size = new System.Drawing.Size(122, 15);
            this.lblCard3Title.TabIndex = 0;
            this.lblCard3Title.Text = "Voucher Terjadwal";
            this.lblCard3Title.TextAlign = System.Drawing.ContentAlignment.MiddleRight;
            // 
            // lblCard3Val
            // 
            this.lblCard3Val.Font = new System.Drawing.Font("Segoe UI", 10.5F, System.Drawing.FontStyle.Bold);
            this.lblCard3Val.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(21)))), ((int)(((byte)(128)))), ((int)(((byte)(61)))));
            this.lblCard3Val.Location = new System.Drawing.Point(4, 23);
            this.lblCard3Val.Name = "lblCard3Val";
            this.lblCard3Val.Size = new System.Drawing.Size(122, 22);
            this.lblCard3Val.TabIndex = 1;
            this.lblCard3Val.Text = "Rp 8.420.000";
            this.lblCard3Val.TextAlign = System.Drawing.ContentAlignment.MiddleRight;
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
            this.txtSearch.Size = new System.Drawing.Size(270, 27);
            this.txtSearch.TabIndex = 0;
            this.txtSearch.Text = "Look for a voucher code or discount details...";
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
            this.btnSearch.Location = new System.Drawing.Point(286, 12);
            this.btnSearch.Name = "btnSearch";
            this.btnSearch.Size = new System.Drawing.Size(72, 26);
            this.btnSearch.TabIndex = 1;
            this.btnSearch.Text = "🔍 Search";
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
            this.pnlTableContainer.Controls.Add(this.dgvDiskon);
            this.pnlTableContainer.Controls.Add(this.pnlTableHeader);
            this.pnlTableContainer.Controls.Add(this.pnlPagination);
            this.pnlTableContainer.Dock = System.Windows.Forms.DockStyle.Fill;
            this.pnlTableContainer.Location = new System.Drawing.Point(12, 12);
            this.pnlTableContainer.Name = "pnlTableContainer";
            this.pnlTableContainer.Size = new System.Drawing.Size(706, 722);
            this.pnlTableContainer.TabIndex = 0;
            // 
            // dgvDiskon
            // 
            this.dgvDiskon.AllowUserToAddRows = false;
            this.dgvDiskon.AllowUserToDeleteRows = false;
            this.dgvDiskon.AllowUserToResizeRows = false;
            this.dgvDiskon.AutoSizeColumnsMode = System.Windows.Forms.DataGridViewAutoSizeColumnsMode.Fill;
            this.dgvDiskon.BackgroundColor = System.Drawing.Color.White;
            this.dgvDiskon.BorderStyle = System.Windows.Forms.BorderStyle.None;
            this.dgvDiskon.CellBorderStyle = System.Windows.Forms.DataGridViewCellBorderStyle.SingleHorizontal;
            this.dgvDiskon.ColumnHeadersBorderStyle = System.Windows.Forms.DataGridViewHeaderBorderStyle.Single;
            this.dgvDiskon.ColumnHeadersHeight = 36;
            this.dgvDiskon.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.DisableResizing;
            this.dgvDiskon.Dock = System.Windows.Forms.DockStyle.Fill;
            this.dgvDiskon.EnableHeadersVisualStyles = false;
            this.dgvDiskon.GridColor = System.Drawing.Color.FromArgb(((int)(((byte)(226)))), ((int)(((byte)(232)))), ((int)(((byte)(240)))));
            this.dgvDiskon.Location = new System.Drawing.Point(0, 34);
            this.dgvDiskon.MultiSelect = false;
            this.dgvDiskon.Name = "dgvDiskon";
            this.dgvDiskon.RowHeadersVisible = false;
            this.dgvDiskon.RowHeadersWidth = 51;
            this.dgvDiskon.RowTemplate.Height = 46;
            this.dgvDiskon.SelectionMode = System.Windows.Forms.DataGridViewSelectionMode.FullRowSelect;
            this.dgvDiskon.Size = new System.Drawing.Size(704, 650);
            this.dgvDiskon.TabIndex = 0;
            this.dgvDiskon.CellClick += new System.Windows.Forms.DataGridViewCellEventHandler(this.dgvDiskon_CellClick);
            this.dgvDiskon.CellFormatting += new System.Windows.Forms.DataGridViewCellFormattingEventHandler(this.dgvDiskon_CellFormatting);
            // 
            // pnlTableHeader
            // 
            this.pnlTableHeader.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(241)))), ((int)(((byte)(245)))), ((int)(((byte)(249)))));
            this.pnlTableHeader.Controls.Add(this.lblDataSet);
            this.pnlTableHeader.Dock = System.Windows.Forms.DockStyle.Top;
            this.pnlTableHeader.Location = new System.Drawing.Point(0, 0);
            this.pnlTableHeader.Name = "pnlTableHeader";
            this.pnlTableHeader.Size = new System.Drawing.Size(704, 34);
            this.pnlTableHeader.TabIndex = 1;
            // 
            // lblDataSet
            // 
            this.lblDataSet.AutoSize = true;
            this.lblDataSet.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.lblDataSet.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.lblDataSet.Location = new System.Drawing.Point(10, 9);
            this.lblDataSet.Name = "lblDataSet";
            this.lblDataSet.Size = new System.Drawing.Size(225, 20);
            this.lblDataSet.TabIndex = 0;
            this.lblDataSet.Text = "🗄️ Data Set: tbl_diskon_kamus";
            // 
            // pnlPagination
            // 
            this.pnlPagination.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(248)))), ((int)(((byte)(250)))), ((int)(((byte)(252)))));
            this.pnlPagination.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.pnlPagination.Controls.Add(this.lblPageInfo);
            this.pnlPagination.Controls.Add(this.btnPageFirst);
            this.pnlPagination.Controls.Add(this.btnPagePrev);
            this.pnlPagination.Controls.Add(this.btnPage1);
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
            this.lblPageInfo.Size = new System.Drawing.Size(209, 19);
            this.lblPageInfo.TabIndex = 0;
            this.lblPageInfo.Text = "Menampilkan 1 - 5 dari 5 diskon";
            // 
            // btnPageFirst
            // 
            this.btnPageFirst.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.btnPageFirst.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.btnPageFirst.Location = new System.Drawing.Point(565, 6);
            this.btnPageFirst.Name = "btnPageFirst";
            this.btnPageFirst.Size = new System.Drawing.Size(24, 23);
            this.btnPageFirst.TabIndex = 1;
            this.btnPageFirst.Text = "«";
            // 
            // btnPagePrev
            // 
            this.btnPagePrev.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.btnPagePrev.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.btnPagePrev.Location = new System.Drawing.Point(592, 6);
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
            this.btnPage1.Location = new System.Drawing.Point(619, 6);
            this.btnPage1.Name = "btnPage1";
            this.btnPage1.Size = new System.Drawing.Size(24, 23);
            this.btnPage1.TabIndex = 3;
            this.btnPage1.Text = "1";
            this.btnPage1.UseVisualStyleBackColor = false;
            // 
            // btnPageNext
            // 
            this.btnPageNext.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.btnPageNext.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.btnPageNext.Location = new System.Drawing.Point(646, 6);
            this.btnPageNext.Name = "btnPageNext";
            this.btnPageNext.Size = new System.Drawing.Size(24, 23);
            this.btnPageNext.TabIndex = 4;
            this.btnPageNext.Text = ">";
            // 
            // btnPageLast
            // 
            this.btnPageLast.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.btnPageLast.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.btnPageLast.Location = new System.Drawing.Point(673, 6);
            this.btnPageLast.Name = "btnPageLast";
            this.btnPageLast.Size = new System.Drawing.Size(24, 23);
            this.btnPageLast.TabIndex = 5;
            this.btnPageLast.Text = "»";
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
            this.pnlDialogBody.Controls.Add(this.lblKode);
            this.pnlDialogBody.Controls.Add(this.txtKode);
            this.pnlDialogBody.Controls.Add(this.lblTipe);
            this.pnlDialogBody.Controls.Add(this.cmbTipe);
            this.pnlDialogBody.Controls.Add(this.lblNilai);
            this.pnlDialogBody.Controls.Add(this.txtNilai);
            this.pnlDialogBody.Controls.Add(this.lblSuffix);
            this.pnlDialogBody.Controls.Add(this.lblNilaiHint);
            this.pnlDialogBody.Controls.Add(this.lblMinBeli);
            this.pnlDialogBody.Controls.Add(this.txtMinBeli);
            this.pnlDialogBody.Controls.Add(this.lblMasaBerlaku);
            this.pnlDialogBody.Controls.Add(this.dtpMasaBerlaku);
            this.pnlDialogBody.Controls.Add(this.dtpJamBerlaku);
            this.pnlDialogBody.Controls.Add(this.grpSyarat);
            this.pnlDialogBody.Controls.Add(this.lblCatatan);
            this.pnlDialogBody.Controls.Add(this.txtCatatan);
            this.pnlDialogBody.Dock = System.Windows.Forms.DockStyle.Fill;
            this.pnlDialogBody.Location = new System.Drawing.Point(0, 36);
            this.pnlDialogBody.Name = "pnlDialogBody";
            this.pnlDialogBody.Size = new System.Drawing.Size(428, 638);
            this.pnlDialogBody.TabIndex = 0;
            // 
            // lblKode
            // 
            this.lblKode.AutoSize = true;
            this.lblKode.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.lblKode.Location = new System.Drawing.Point(14, 14);
            this.lblKode.Name = "lblKode";
            this.lblKode.Size = new System.Drawing.Size(108, 20);
            this.lblKode.TabIndex = 0;
            this.lblKode.Text = "Kode Diskon *";
            // 
            // txtKode
            // 
            this.txtKode.CharacterCasing = System.Windows.Forms.CharacterCasing.Upper;
            this.txtKode.Font = new System.Drawing.Font("Segoe UI", 9F, System.Drawing.FontStyle.Bold);
            this.txtKode.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(37)))), ((int)(((byte)(99)))), ((int)(((byte)(235)))));
            this.txtKode.Location = new System.Drawing.Point(14, 34);
            this.txtKode.Name = "txtKode";
            this.txtKode.Size = new System.Drawing.Size(398, 27);
            this.txtKode.TabIndex = 1;
            this.txtKode.Text = "MALANG50";
            // 
            // lblTipe
            // 
            this.lblTipe.AutoSize = true;
            this.lblTipe.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.lblTipe.Location = new System.Drawing.Point(14, 70);
            this.lblTipe.Name = "lblTipe";
            this.lblTipe.Size = new System.Drawing.Size(102, 20);
            this.lblTipe.TabIndex = 2;
            this.lblTipe.Text = "Tipe Diskon *";
            // 
            // cmbTipe
            // 
            this.cmbTipe.DropDownStyle = System.Windows.Forms.ComboBoxStyle.DropDownList;
            this.cmbTipe.Items.AddRange(new object[] {
            "Persentase (%)",
            "Potongan Langsung (Rp)"});
            this.cmbTipe.Location = new System.Drawing.Point(14, 90);
            this.cmbTipe.Name = "cmbTipe";
            this.cmbTipe.Size = new System.Drawing.Size(398, 28);
            this.cmbTipe.TabIndex = 3;
            this.cmbTipe.SelectedIndexChanged += new System.EventHandler(this.cmbTipe_SelectedIndexChanged);
            // 
            // lblNilai
            // 
            this.lblNilai.AutoSize = true;
            this.lblNilai.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.lblNilai.Location = new System.Drawing.Point(14, 126);
            this.lblNilai.Name = "lblNilai";
            this.lblNilai.Size = new System.Drawing.Size(124, 20);
            this.lblNilai.TabIndex = 4;
            this.lblNilai.Text = "Nilai Potongan *";
            // 
            // txtNilai
            // 
            this.txtNilai.Font = new System.Drawing.Font("Segoe UI", 9F, System.Drawing.FontStyle.Bold);
            this.txtNilai.Location = new System.Drawing.Point(14, 146);
            this.txtNilai.Name = "txtNilai";
            this.txtNilai.Size = new System.Drawing.Size(366, 27);
            this.txtNilai.TabIndex = 5;
            this.txtNilai.Text = "50";
            // 
            // lblSuffix
            // 
            this.lblSuffix.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(226)))), ((int)(((byte)(232)))), ((int)(((byte)(240)))));
            this.lblSuffix.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.lblSuffix.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.lblSuffix.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(71)))), ((int)(((byte)(85)))), ((int)(((byte)(105)))));
            this.lblSuffix.Location = new System.Drawing.Point(380, 146);
            this.lblSuffix.Name = "lblSuffix";
            this.lblSuffix.Size = new System.Drawing.Size(32, 25);
            this.lblSuffix.TabIndex = 6;
            this.lblSuffix.Text = "%";
            this.lblSuffix.TextAlign = System.Drawing.ContentAlignment.MiddleCenter;
            // 
            // lblNilaiHint
            // 
            this.lblNilaiHint.AutoSize = true;
            this.lblNilaiHint.Font = new System.Drawing.Font("Segoe UI", 7.5F);
            this.lblNilaiHint.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(100)))), ((int)(((byte)(116)))), ((int)(((byte)(139)))));
            this.lblNilaiHint.Location = new System.Drawing.Point(14, 174);
            this.lblNilaiHint.Name = "lblNilaiHint";
            this.lblNilaiHint.Size = new System.Drawing.Size(272, 17);
            this.lblNilaiHint.TabIndex = 7;
            this.lblNilaiHint.Text = "Masukkan angka persentase atau nominal Rp";
            // 
            // lblMinBeli
            // 
            this.lblMinBeli.AutoSize = true;
            this.lblMinBeli.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.lblMinBeli.Location = new System.Drawing.Point(14, 198);
            this.lblMinBeli.Name = "lblMinBeli";
            this.lblMinBeli.Size = new System.Drawing.Size(178, 20);
            this.lblMinBeli.TabIndex = 10;
            this.lblMinBeli.Text = "Minimal Pembelian (Rp)";
            // 
            // txtMinBeli
            // 
            this.txtMinBeli.Location = new System.Drawing.Point(14, 218);
            this.txtMinBeli.Name = "txtMinBeli";
            this.txtMinBeli.Size = new System.Drawing.Size(398, 27);
            this.txtMinBeli.TabIndex = 11;
            this.txtMinBeli.Text = "0";
            // 
            // lblMasaBerlaku
            // 
            this.lblMasaBerlaku.AutoSize = true;
            this.lblMasaBerlaku.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.lblMasaBerlaku.Location = new System.Drawing.Point(14, 310);
            this.lblMasaBerlaku.Name = "lblMasaBerlaku";
            this.lblMasaBerlaku.Size = new System.Drawing.Size(157, 20);
            this.lblMasaBerlaku.TabIndex = 12;
            this.lblMasaBerlaku.Text = "Masa Berlaku Hingga";
            // 
            // dtpMasaBerlaku - pilih tanggal melalui kalender dropdown
            // 
            this.dtpMasaBerlaku.CustomFormat = "dd MMMM yyyy";
            this.dtpMasaBerlaku.Font = new System.Drawing.Font("Segoe UI", 9F);
            this.dtpMasaBerlaku.Format = System.Windows.Forms.DateTimePickerFormat.Custom;
            this.dtpMasaBerlaku.ShowUpDown = false;
            this.dtpMasaBerlaku.Location = new System.Drawing.Point(14, 330);
            this.dtpMasaBerlaku.Name = "dtpMasaBerlaku";
            this.dtpMasaBerlaku.Size = new System.Drawing.Size(265, 27);
            this.dtpMasaBerlaku.TabIndex = 13;
            // 
            // dtpJamBerlaku - ubah jam dengan cepat
            // 
            this.dtpJamBerlaku.CustomFormat = "HH:mm";
            this.dtpJamBerlaku.Font = new System.Drawing.Font("Segoe UI", 9F);
            this.dtpJamBerlaku.Format = System.Windows.Forms.DateTimePickerFormat.Custom;
            this.dtpJamBerlaku.ShowUpDown = true;
            this.dtpJamBerlaku.Location = new System.Drawing.Point(285, 330);
            this.dtpJamBerlaku.Name = "dtpJamBerlaku";
            this.dtpJamBerlaku.Size = new System.Drawing.Size(127, 27);
            this.dtpJamBerlaku.TabIndex = 14;
            // 
            // grpSyarat
            // 
            this.grpSyarat.Controls.Add(this.chkAktif);
            
            this.grpSyarat.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.grpSyarat.Location = new System.Drawing.Point(14, 368);
            this.grpSyarat.Name = "grpSyarat";
            this.grpSyarat.Size = new System.Drawing.Size(398, 52);
            this.grpSyarat.TabIndex = 14;
            this.grpSyarat.TabStop = false;
            this.grpSyarat.Text = "Status Diskon";
            // 
            // chkAktif
            // 
            this.chkAktif.AutoSize = true;
            this.chkAktif.Checked = true;
            this.chkAktif.CheckState = System.Windows.Forms.CheckState.Checked;
            this.chkAktif.Font = new System.Drawing.Font("Segoe UI", 8.5F);
            this.chkAktif.Location = new System.Drawing.Point(12, 23);
            this.chkAktif.Name = "chkAktif";
            this.chkAktif.Size = new System.Drawing.Size(241, 24);
            this.chkAktif.TabIndex = 0;
            this.chkAktif.Text = "Aktifkan Diskon (Status Berlaku)";
            // 
            // lblCatatan
            // 
            this.lblCatatan.AutoSize = true;
            this.lblCatatan.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.lblCatatan.Location = new System.Drawing.Point(14, 430);
            this.lblCatatan.Name = "lblCatatan";
            this.lblCatatan.Size = new System.Drawing.Size(194, 20);
            this.lblCatatan.TabIndex = 15;
            this.lblCatatan.Text = "Catatan & Deskripsi Internal";
            // 
            // txtCatatan
            // 
            this.txtCatatan.Location = new System.Drawing.Point(14, 450);
            this.txtCatatan.Multiline = true;
            this.txtCatatan.Name = "txtCatatan";
            this.txtCatatan.Size = new System.Drawing.Size(398, 52);
            this.txtCatatan.TabIndex = 16;
            this.txtCatatan.Text = "Promo spesial peluncuran dialek Boso Walikan Dinoyo & Kajoetangan.";
            // 
            // pnlDialogHeader
            // 
            this.pnlDialogHeader.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(238)))), ((int)(((byte)(242)))), ((int)(((byte)(255)))));
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
            this.lblDialogTitle.Font = new System.Drawing.Font("Segoe UI", 9F, System.Drawing.FontStyle.Bold);
            this.lblDialogTitle.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.lblDialogTitle.Location = new System.Drawing.Point(12, 9);
            this.lblDialogTitle.Name = "lblDialogTitle";
            this.lblDialogTitle.Size = new System.Drawing.Size(315, 20);
            this.lblDialogTitle.TabIndex = 0;
            this.lblDialogTitle.Text = "Dialog: [Tambah/Edit Diskon - MALANG50]";
            // 
            // btnCloseDialog
            // 
            this.btnCloseDialog.FlatAppearance.BorderSize = 0;
            this.btnCloseDialog.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.btnCloseDialog.Font = new System.Drawing.Font("Segoe UI", 9F);
            this.btnCloseDialog.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(100)))), ((int)(((byte)(116)))), ((int)(((byte)(139)))));
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
            this.pnlDialogFooter.Controls.Add(this.btnHapusDiskon);
            this.pnlDialogFooter.Controls.Add(this.btnSimpanDiskon);
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
            this.btnBatal.Location = new System.Drawing.Point(144, 8);
            this.btnBatal.Name = "btnBatal";
            this.btnBatal.Size = new System.Drawing.Size(56, 28);
            this.btnBatal.TabIndex = 0;
            this.btnBatal.Text = "Batal";
            this.btnBatal.UseVisualStyleBackColor = false;
            this.btnBatal.Click += new System.EventHandler(this.btnBatal_Click);
            // 
            // btnHapusDiskon
            // 
            this.btnHapusDiskon.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(254)))), ((int)(((byte)(242)))), ((int)(((byte)(242)))));
            this.btnHapusDiskon.FlatAppearance.BorderColor = System.Drawing.Color.FromArgb(((int)(((byte)(252)))), ((int)(((byte)(165)))), ((int)(((byte)(165)))));
            this.btnHapusDiskon.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.btnHapusDiskon.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.btnHapusDiskon.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(220)))), ((int)(((byte)(38)))), ((int)(((byte)(38)))));
            this.btnHapusDiskon.Location = new System.Drawing.Point(206, 8);
            this.btnHapusDiskon.Name = "btnHapusDiskon";
            this.btnHapusDiskon.Size = new System.Drawing.Size(92, 28);
            this.btnHapusDiskon.TabIndex = 1;
            this.btnHapusDiskon.Text = "Hapus Diskon";
            this.btnHapusDiskon.UseVisualStyleBackColor = false;
            this.btnHapusDiskon.Click += new System.EventHandler(this.btnHapusDiskon_Click);
            // 
            // btnSimpanDiskon
            // 
            this.btnSimpanDiskon.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(37)))), ((int)(((byte)(99)))), ((int)(((byte)(235)))));
            this.btnSimpanDiskon.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.btnSimpanDiskon.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.btnSimpanDiskon.ForeColor = System.Drawing.Color.White;
            this.btnSimpanDiskon.Location = new System.Drawing.Point(304, 8);
            this.btnSimpanDiskon.Name = "btnSimpanDiskon";
            this.btnSimpanDiskon.Size = new System.Drawing.Size(110, 28);
            this.btnSimpanDiskon.TabIndex = 2;
            this.btnSimpanDiskon.Text = "💾 Simpan Diskon";
            this.btnSimpanDiskon.UseVisualStyleBackColor = false;
            this.btnSimpanDiskon.Click += new System.EventHandler(this.btnSimpanDiskon_Click);
            // 
            // DiscountControl
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(8F, 20F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.BackColor = System.Drawing.Color.White;
            this.Controls.Add(this.pnlMainBody);
            this.Controls.Add(this.pnlSearchBar);
            this.Controls.Add(this.pnlHeader);
            this.Font = new System.Drawing.Font("Segoe UI", 9F);
            this.Name = "DiscountControl";
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
            ((System.ComponentModel.ISupportInitialize)(this.dgvDiskon)).EndInit();
            this.pnlTableHeader.ResumeLayout(false);
            this.pnlTableHeader.PerformLayout();
            this.pnlPagination.ResumeLayout(false);
            this.pnlPagination.PerformLayout();
            this.pnlDialog.ResumeLayout(false);
            this.pnlDialogBody.ResumeLayout(false);
            this.pnlDialogBody.PerformLayout();
            this.grpSyarat.ResumeLayout(false);
            this.grpSyarat.PerformLayout();
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
        private System.Windows.Forms.Label lblCard1Title;
        private System.Windows.Forms.Label lblCard1Val;
        private System.Windows.Forms.Panel pnlCard2;
        private System.Windows.Forms.Label lblCard2Title;
        private System.Windows.Forms.Label lblCard2Val;
        private System.Windows.Forms.Panel pnlCard3;
        private System.Windows.Forms.Label lblCard3Title;
        private System.Windows.Forms.Label lblCard3Val;

        private System.Windows.Forms.Panel pnlSearchBar;
        private System.Windows.Forms.TextBox txtSearch;
        private System.Windows.Forms.Button btnSearch;

        private System.Windows.Forms.Panel pnlMainBody;
        private System.Windows.Forms.Panel pnlTableContainer;
        private System.Windows.Forms.Panel pnlTableHeader;
        private System.Windows.Forms.Label lblDataSet;
        private System.Windows.Forms.DataGridView dgvDiskon;
        private System.Windows.Forms.Panel pnlPagination;
        private System.Windows.Forms.Label lblPageInfo;
        private System.Windows.Forms.Button btnPageFirst;
        private System.Windows.Forms.Button btnPagePrev;
        private System.Windows.Forms.Button btnPage1;
        private System.Windows.Forms.Button btnPageNext;
        private System.Windows.Forms.Button btnPageLast;

        private System.Windows.Forms.Panel pnlDialog;
        private System.Windows.Forms.Panel pnlDialogHeader;
        private System.Windows.Forms.Label lblDialogTitle;
        private System.Windows.Forms.Button btnCloseDialog;
        private System.Windows.Forms.Panel pnlDialogBody;
        private System.Windows.Forms.Label lblKode;
        private System.Windows.Forms.TextBox txtKode;
        private System.Windows.Forms.Label lblTipe;
        private System.Windows.Forms.ComboBox cmbTipe;
        private System.Windows.Forms.Label lblNilai;
        private System.Windows.Forms.TextBox txtNilai;
        private System.Windows.Forms.Label lblSuffix;
        private System.Windows.Forms.Label lblNilaiHint;
        private System.Windows.Forms.Label lblMinBeli;
        private System.Windows.Forms.TextBox txtMinBeli;
        private System.Windows.Forms.Label lblMasaBerlaku;
        private System.Windows.Forms.DateTimePicker dtpMasaBerlaku;
        private System.Windows.Forms.DateTimePicker dtpJamBerlaku;
        private System.Windows.Forms.GroupBox grpSyarat;
        private System.Windows.Forms.CheckBox chkAktif;
        private System.Windows.Forms.Label lblCatatan;
        private System.Windows.Forms.TextBox txtCatatan;
        private System.Windows.Forms.Panel pnlDialogFooter;
        private System.Windows.Forms.Button btnBatal;
        private System.Windows.Forms.Button btnHapusDiskon;
        private System.Windows.Forms.Button btnSimpanDiskon;
    }
}