namespace dekstop
{
    partial class ReceiptsControl
    {
        private System.ComponentModel.IContainer components = null;
        private System.Windows.Forms.Panel topHeaderPanel;
        private System.Windows.Forms.Label titleLabel;
        private System.Windows.Forms.Label countBadgeLabel;
        private System.Windows.Forms.TextBox searchReceiptBox;
        private System.Windows.Forms.Panel bodyPanel;
        private System.Windows.Forms.DataGridView receiptsGrid;
        private System.Windows.Forms.DataGridViewTextBoxColumn colNo;
        private System.Windows.Forms.DataGridViewTextBoxColumn colReceiptId;
        private System.Windows.Forms.DataGridViewTextBoxColumn colTrxNo;
        private System.Windows.Forms.DataGridViewTextBoxColumn colProduct;
        private System.Windows.Forms.DataGridViewTextBoxColumn colDate;
        private System.Windows.Forms.DataGridViewTextBoxColumn colTotal;
        private System.Windows.Forms.DataGridViewTextBoxColumn colStatus;
        private System.Windows.Forms.DataGridViewButtonColumn colPreview;
        private System.Windows.Forms.DataGridViewButtonColumn colPrint;
        private System.Windows.Forms.Panel footerPanel;
        private System.Windows.Forms.Label paginationSummaryLabel;
        private System.Windows.Forms.Button firstPageBtn;
        private System.Windows.Forms.Button prevPageBtn;
        private System.Windows.Forms.Label pageNumberLabel;
        private System.Windows.Forms.Button nextPageBtn;
        private System.Windows.Forms.Button lastPageBtn;

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
            System.Windows.Forms.DataGridViewCellStyle headerStyle = new System.Windows.Forms.DataGridViewCellStyle();
            System.Windows.Forms.DataGridViewCellStyle cellStyle = new System.Windows.Forms.DataGridViewCellStyle();
            System.Windows.Forms.DataGridViewCellStyle noStyle = new System.Windows.Forms.DataGridViewCellStyle();
            System.Windows.Forms.DataGridViewCellStyle totalStyle = new System.Windows.Forms.DataGridViewCellStyle();
            System.Windows.Forms.DataGridViewCellStyle statusStyle = new System.Windows.Forms.DataGridViewCellStyle();
            this.topHeaderPanel = new System.Windows.Forms.Panel();
            this.searchReceiptBox = new System.Windows.Forms.TextBox();
            this.countBadgeLabel = new System.Windows.Forms.Label();
            this.titleLabel = new System.Windows.Forms.Label();
            this.bodyPanel = new System.Windows.Forms.Panel();
            this.receiptsGrid = new System.Windows.Forms.DataGridView();
            this.colNo = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.colReceiptId = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.colTrxNo = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.colProduct = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.colDate = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.colTotal = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.colStatus = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.colPreview = new System.Windows.Forms.DataGridViewButtonColumn();
            this.colPrint = new System.Windows.Forms.DataGridViewButtonColumn();
            this.footerPanel = new System.Windows.Forms.Panel();
            this.lastPageBtn = new System.Windows.Forms.Button();
            this.nextPageBtn = new System.Windows.Forms.Button();
            this.pageNumberLabel = new System.Windows.Forms.Label();
            this.prevPageBtn = new System.Windows.Forms.Button();
            this.firstPageBtn = new System.Windows.Forms.Button();
            this.paginationSummaryLabel = new System.Windows.Forms.Label();
            this.topHeaderPanel.SuspendLayout();
            this.bodyPanel.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.receiptsGrid)).BeginInit();
            this.footerPanel.SuspendLayout();
            this.SuspendLayout();
            // 
            // topHeaderPanel
            // 
            this.topHeaderPanel.BackColor = System.Drawing.Color.White;
            this.topHeaderPanel.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.topHeaderPanel.Controls.Add(this.searchReceiptBox);
            this.topHeaderPanel.Controls.Add(this.countBadgeLabel);
            this.topHeaderPanel.Controls.Add(this.titleLabel);
            this.topHeaderPanel.Dock = System.Windows.Forms.DockStyle.Top;
            this.topHeaderPanel.Location = new System.Drawing.Point(0, 0);
            this.topHeaderPanel.Name = "topHeaderPanel";
            this.topHeaderPanel.Size = new System.Drawing.Size(1138, 46);
            this.topHeaderPanel.TabIndex = 0;
            // 
            // searchReceiptBox
            // 
            this.searchReceiptBox.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.searchReceiptBox.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.searchReceiptBox.Font = new System.Drawing.Font("Georgia", 8.5F);
            this.searchReceiptBox.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(100)))), ((int)(((byte)(116)))), ((int)(((byte)(139)))));
            this.searchReceiptBox.Location = new System.Drawing.Point(926, 11);
            this.searchReceiptBox.Name = "searchReceiptBox";
            this.searchReceiptBox.Size = new System.Drawing.Size(198, 20);
            this.searchReceiptBox.TabIndex = 2;
            this.searchReceiptBox.Text = "";
            this.searchReceiptBox.TextChanged += new System.EventHandler(this.SearchReceiptBox_TextChanged);
            // 
            // countBadgeLabel
            // 
            this.countBadgeLabel.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(224)))), ((int)(((byte)(231)))), ((int)(((byte)(255)))));
            this.countBadgeLabel.Font = new System.Drawing.Font("Segoe UI", 8F, System.Drawing.FontStyle.Bold);
            this.countBadgeLabel.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(37)))), ((int)(((byte)(99)))), ((int)(((byte)(235)))));
            this.countBadgeLabel.Location = new System.Drawing.Point(254, 13);
            this.countBadgeLabel.Name = "countBadgeLabel";
            this.countBadgeLabel.Size = new System.Drawing.Size(74, 20);
            this.countBadgeLabel.TabIndex = 1;
            this.countBadgeLabel.Text = "128 Selesai";
            this.countBadgeLabel.TextAlign = System.Drawing.ContentAlignment.MiddleCenter;
            // 
            // titleLabel
            // 
            this.titleLabel.AutoSize = true;
            this.titleLabel.Font = new System.Drawing.Font("Georgia", 10F, System.Drawing.FontStyle.Bold);
            this.titleLabel.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.titleLabel.Location = new System.Drawing.Point(14, 14);
            this.titleLabel.Name = "titleLabel";
            this.titleLabel.Size = new System.Drawing.Size(234, 17);
            this.titleLabel.TabIndex = 0;
            this.titleLabel.Text = "List of Receipts & Payment Archives";
            // 
            // bodyPanel
            // 
            this.bodyPanel.BackColor = System.Drawing.Color.White;
            this.bodyPanel.Controls.Add(this.receiptsGrid);
            this.bodyPanel.Controls.Add(this.footerPanel);
            this.bodyPanel.Dock = System.Windows.Forms.DockStyle.Fill;
            this.bodyPanel.Location = new System.Drawing.Point(0, 46);
            this.bodyPanel.Name = "bodyPanel";
            this.bodyPanel.Padding = new System.Windows.Forms.Padding(14);
            this.bodyPanel.Size = new System.Drawing.Size(1138, 714);
            this.bodyPanel.TabIndex = 1;
            // 
            // receiptsGrid
            // 
            this.receiptsGrid.AllowUserToAddRows = false;
            this.receiptsGrid.AllowUserToDeleteRows = false;
            this.receiptsGrid.AllowUserToResizeRows = false;
            this.receiptsGrid.AutoSizeColumnsMode = System.Windows.Forms.DataGridViewAutoSizeColumnsMode.Fill;
            this.receiptsGrid.BackgroundColor = System.Drawing.Color.White;
            this.receiptsGrid.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.receiptsGrid.CellBorderStyle = System.Windows.Forms.DataGridViewCellBorderStyle.SingleHorizontal;
            this.receiptsGrid.ColumnHeadersBorderStyle = System.Windows.Forms.DataGridViewHeaderBorderStyle.Single;
            headerStyle.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleCenter;
            headerStyle.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(241)))), ((int)(((byte)(245)))), ((int)(((byte)(249)))));
            headerStyle.Font = new System.Drawing.Font("Georgia", 8.25F, System.Drawing.FontStyle.Bold);
            headerStyle.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            headerStyle.SelectionBackColor = System.Drawing.Color.FromArgb(((int)(((byte)(241)))), ((int)(((byte)(245)))), ((int)(((byte)(249)))));
            headerStyle.SelectionForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            headerStyle.WrapMode = System.Windows.Forms.DataGridViewTriState.True;
            this.receiptsGrid.ColumnHeadersDefaultCellStyle = headerStyle;
            this.receiptsGrid.ColumnHeadersHeight = 38;
            this.receiptsGrid.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.DisableResizing;
            this.receiptsGrid.Columns.AddRange(new System.Windows.Forms.DataGridViewColumn[] {
            this.colNo,
            this.colReceiptId,
            this.colTrxNo,
            this.colProduct,
            this.colDate,
            this.colTotal,
            this.colStatus,
            this.colPreview,
            this.colPrint});
            cellStyle.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleLeft;
            cellStyle.BackColor = System.Drawing.Color.White;
            cellStyle.Font = new System.Drawing.Font("Segoe UI", 8.5F);
            cellStyle.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(51)))), ((int)(((byte)(65)))), ((int)(((byte)(85)))));
            cellStyle.Padding = new System.Windows.Forms.Padding(6, 0, 6, 0);
            cellStyle.SelectionBackColor = System.Drawing.Color.FromArgb(((int)(((byte)(226)))), ((int)(((byte)(236)))), ((int)(((byte)(255)))));
            cellStyle.SelectionForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            cellStyle.WrapMode = System.Windows.Forms.DataGridViewTriState.False;
            this.receiptsGrid.DefaultCellStyle = cellStyle;
            this.receiptsGrid.Dock = System.Windows.Forms.DockStyle.Fill;
            this.receiptsGrid.EnableHeadersVisualStyles = false;
            this.receiptsGrid.GridColor = System.Drawing.Color.FromArgb(((int)(((byte)(226)))), ((int)(((byte)(232)))), ((int)(((byte)(240)))));
            this.receiptsGrid.Location = new System.Drawing.Point(14, 14);
            this.receiptsGrid.MultiSelect = false;
            this.receiptsGrid.Name = "receiptsGrid";
            this.receiptsGrid.ReadOnly = true;
            this.receiptsGrid.RowHeadersVisible = false;
            this.receiptsGrid.RowTemplate.Height = 36;
            this.receiptsGrid.SelectionMode = System.Windows.Forms.DataGridViewSelectionMode.FullRowSelect;
            this.receiptsGrid.Size = new System.Drawing.Size(1110, 650);
            this.receiptsGrid.TabIndex = 0;
            this.receiptsGrid.CellContentClick += new System.Windows.Forms.DataGridViewCellEventHandler(this.ReceiptsGrid_CellContentClick);
            // 
            // colNo
            // 
            noStyle.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleCenter;
            this.colNo.DefaultCellStyle = noStyle;
            this.colNo.FillWeight = 36F;
            this.colNo.HeaderText = "No.";
            this.colNo.Name = "colNo";
            this.colNo.ReadOnly = true;
            // 
            // colReceiptId
            // 
            this.colReceiptId.FillWeight = 95F;
            this.colReceiptId.HeaderText = "ID Kwitansi";
            this.colReceiptId.Name = "colReceiptId";
            this.colReceiptId.ReadOnly = true;
            // 
            // colTrxNo
            // 
            this.colTrxNo.FillWeight = 95F;
            this.colTrxNo.HeaderText = "No Transaksi";
            this.colTrxNo.Name = "colTrxNo";
            this.colTrxNo.ReadOnly = true;
            // 
            // colProduct
            // 
            this.colProduct.FillWeight = 185F;
            this.colProduct.HeaderText = "Judul Kamus / Produk Digital";
            this.colProduct.Name = "colProduct";
            this.colProduct.ReadOnly = true;
            // 
            // colDate
            // 
            this.colDate.FillWeight = 95F;
            this.colDate.HeaderText = "Tanggal Lunas";
            this.colDate.Name = "colDate";
            this.colDate.ReadOnly = true;
            // 
            // colTotal
            // 
            totalStyle.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleRight;
            totalStyle.Font = new System.Drawing.Font("Georgia", 8.25F, System.Drawing.FontStyle.Bold);
            this.colTotal.DefaultCellStyle = totalStyle;
            this.colTotal.FillWeight = 85F;
            this.colTotal.HeaderText = "Total (Rp)";
            this.colTotal.Name = "colTotal";
            this.colTotal.ReadOnly = true;
            // 
            // colStatus
            // 
            statusStyle.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleCenter;
            statusStyle.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(220)))), ((int)(((byte)(252)))), ((int)(((byte)(231)))));
            statusStyle.Font = new System.Drawing.Font("Segoe UI", 8F, System.Drawing.FontStyle.Bold);
            statusStyle.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(21)))), ((int)(((byte)(128)))), ((int)(((byte)(61)))));
            this.colStatus.DefaultCellStyle = statusStyle;
            this.colStatus.FillWeight = 75F;
            this.colStatus.HeaderText = "Status";
            this.colStatus.Name = "colStatus";
            this.colStatus.ReadOnly = true;
            // 
            // colPreview
            // 
            this.colPreview.FillWeight = 66F;
            this.colPreview.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.colPreview.HeaderText = "Aksi";
            this.colPreview.Visible = false;
            this.colPreview.Name = "colPreview";
            this.colPreview.ReadOnly = true;
            // 
            // colPrint
            // 
            this.colPrint.FillWeight = 32F;
            this.colPrint.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.colPrint.HeaderText = "";
            this.colPrint.Name = "colPrint";
            this.colPrint.ReadOnly = true;
            // 
            // footerPanel
            // 
            this.footerPanel.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(248)))), ((int)(((byte)(250)))), ((int)(((byte)(252)))));
            this.footerPanel.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.footerPanel.Controls.Add(this.lastPageBtn);
            this.footerPanel.Controls.Add(this.nextPageBtn);
            this.footerPanel.Controls.Add(this.pageNumberLabel);
            this.footerPanel.Controls.Add(this.prevPageBtn);
            this.footerPanel.Controls.Add(this.firstPageBtn);
            this.footerPanel.Controls.Add(this.paginationSummaryLabel);
            this.footerPanel.Dock = System.Windows.Forms.DockStyle.Bottom;
            this.footerPanel.Location = new System.Drawing.Point(14, 664);
            this.footerPanel.Name = "footerPanel";
            this.footerPanel.Size = new System.Drawing.Size(1110, 36);
            this.footerPanel.TabIndex = 1;
            // 
            // lastPageBtn
            // 
            this.lastPageBtn.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.lastPageBtn.BackColor = System.Drawing.Color.White;
            this.lastPageBtn.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.lastPageBtn.Font = new System.Drawing.Font("Segoe UI", 7.5F);
            this.lastPageBtn.Location = new System.Drawing.Point(1078, 6);
            this.lastPageBtn.Name = "lastPageBtn";
            this.lastPageBtn.Size = new System.Drawing.Size(24, 22);
            this.lastPageBtn.TabIndex = 5;
            this.lastPageBtn.Text = ">|";
            this.lastPageBtn.UseVisualStyleBackColor = false;
            // 
            // nextPageBtn
            // 
            this.nextPageBtn.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.nextPageBtn.BackColor = System.Drawing.Color.White;
            this.nextPageBtn.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.nextPageBtn.Font = new System.Drawing.Font("Segoe UI", 7.5F);
            this.nextPageBtn.Location = new System.Drawing.Point(1050, 6);
            this.nextPageBtn.Name = "nextPageBtn";
            this.nextPageBtn.Size = new System.Drawing.Size(24, 22);
            this.nextPageBtn.TabIndex = 4;
            this.nextPageBtn.Text = ">";
            this.nextPageBtn.UseVisualStyleBackColor = false;
            // 
            // pageNumberLabel
            // 
            this.pageNumberLabel.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.pageNumberLabel.AutoSize = true;
            this.pageNumberLabel.Font = new System.Drawing.Font("Georgia", 8F, System.Drawing.FontStyle.Bold);
            this.pageNumberLabel.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.pageNumberLabel.Location = new System.Drawing.Point(962, 10);
            this.pageNumberLabel.Name = "pageNumberLabel";
            this.pageNumberLabel.Size = new System.Drawing.Size(84, 14);
            this.pageNumberLabel.TabIndex = 3;
            this.pageNumberLabel.Text = "Halaman 1 / 26";
            // 
            // prevPageBtn
            // 
            this.prevPageBtn.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.prevPageBtn.BackColor = System.Drawing.Color.White;
            this.prevPageBtn.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.prevPageBtn.Font = new System.Drawing.Font("Segoe UI", 7.5F);
            this.prevPageBtn.Location = new System.Drawing.Point(932, 6);
            this.prevPageBtn.Name = "prevPageBtn";
            this.prevPageBtn.Size = new System.Drawing.Size(24, 22);
            this.prevPageBtn.TabIndex = 2;
            this.prevPageBtn.Text = "<";
            this.prevPageBtn.UseVisualStyleBackColor = false;
            // 
            // firstPageBtn
            // 
            this.firstPageBtn.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.firstPageBtn.BackColor = System.Drawing.Color.White;
            this.firstPageBtn.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.firstPageBtn.Font = new System.Drawing.Font("Segoe UI", 7.5F);
            this.firstPageBtn.Location = new System.Drawing.Point(904, 6);
            this.firstPageBtn.Name = "firstPageBtn";
            this.firstPageBtn.Size = new System.Drawing.Size(24, 22);
            this.firstPageBtn.TabIndex = 1;
            this.firstPageBtn.Text = "|<";
            this.firstPageBtn.UseVisualStyleBackColor = false;
            // 
            // paginationSummaryLabel
            // 
            this.paginationSummaryLabel.AutoSize = true;
            this.paginationSummaryLabel.Font = new System.Drawing.Font("Georgia", 8F);
            this.paginationSummaryLabel.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(100)))), ((int)(((byte)(116)))), ((int)(((byte)(139)))));
            this.paginationSummaryLabel.Location = new System.Drawing.Point(10, 10);
            this.paginationSummaryLabel.Name = "paginationSummaryLabel";
            this.paginationSummaryLabel.Size = new System.Drawing.Size(218, 14);
            this.paginationSummaryLabel.TabIndex = 0;
            this.paginationSummaryLabel.Text = "Menampilkan 1 - 5 dari 128 Kwitansi Transaksi Selesai";
            // 
            // ReceiptsControl
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.BackColor = System.Drawing.Color.White;
            this.Controls.Add(this.bodyPanel);
            this.Controls.Add(this.topHeaderPanel);
            this.Name = "ReceiptsControl";
            this.Size = new System.Drawing.Size(1138, 760);
            this.topHeaderPanel.ResumeLayout(false);
            this.topHeaderPanel.PerformLayout();
            this.bodyPanel.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)(this.receiptsGrid)).EndInit();
            this.footerPanel.ResumeLayout(false);
            this.footerPanel.PerformLayout();
            this.ResumeLayout(false);
        }

        #endregion
    }
}
