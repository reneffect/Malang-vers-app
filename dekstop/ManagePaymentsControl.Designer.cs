namespace dekstop
{
    partial class ManagePaymentsControl
    {
        private System.ComponentModel.IContainer components = null;
        private System.Windows.Forms.Panel topSearchPanel;
        private System.Windows.Forms.TextBox searchOrderBox;
        private System.Windows.Forms.Panel mainContentPanel;
        private System.Windows.Forms.Panel headerAreaPanel;
        private System.Windows.Forms.Label titleLabel;
        private System.Windows.Forms.Label subtitleLabel;
        private System.Windows.Forms.Label pendingBadgeLabel;
        private System.Windows.Forms.DataGridView paymentsGrid;
        private System.Windows.Forms.DataGridViewTextBoxColumn colNo;
        private System.Windows.Forms.DataGridViewTextBoxColumn colTrxId;
        private System.Windows.Forms.DataGridViewTextBoxColumn colOrderId;
        private System.Windows.Forms.DataGridViewTextBoxColumn colItem;
        private System.Windows.Forms.DataGridViewTextBoxColumn colTotal;
        private System.Windows.Forms.DataGridViewTextBoxColumn colTime;
        private System.Windows.Forms.DataGridViewTextBoxColumn colStatus;
        private System.Windows.Forms.DataGridViewButtonColumn colAction;

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
            System.Windows.Forms.DataGridViewCellStyle gridHeaderStyle = new System.Windows.Forms.DataGridViewCellStyle();
            System.Windows.Forms.DataGridViewCellStyle gridRowStyle = new System.Windows.Forms.DataGridViewCellStyle();
            System.Windows.Forms.DataGridViewCellStyle noColStyle = new System.Windows.Forms.DataGridViewCellStyle();
            System.Windows.Forms.DataGridViewCellStyle priceColStyle = new System.Windows.Forms.DataGridViewCellStyle();
            System.Windows.Forms.DataGridViewCellStyle statusColStyle = new System.Windows.Forms.DataGridViewCellStyle();
            this.topSearchPanel = new System.Windows.Forms.Panel();
            this.searchOrderBox = new System.Windows.Forms.TextBox();
            this.mainContentPanel = new System.Windows.Forms.Panel();
            this.paymentsGrid = new System.Windows.Forms.DataGridView();
            this.colNo = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.colTrxId = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.colOrderId = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.colItem = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.colTotal = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.colTime = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.colStatus = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.colAction = new System.Windows.Forms.DataGridViewButtonColumn();
            this.headerAreaPanel = new System.Windows.Forms.Panel();
            this.pendingBadgeLabel = new System.Windows.Forms.Label();
            this.subtitleLabel = new System.Windows.Forms.Label();
            this.titleLabel = new System.Windows.Forms.Label();
            this.topSearchPanel.SuspendLayout();
            this.mainContentPanel.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.paymentsGrid)).BeginInit();
            this.headerAreaPanel.SuspendLayout();
            this.SuspendLayout();
            // 
            // topSearchPanel
            // 
            this.topSearchPanel.BackColor = System.Drawing.Color.White;
            this.topSearchPanel.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.topSearchPanel.Controls.Add(this.searchOrderBox);
            this.topSearchPanel.Dock = System.Windows.Forms.DockStyle.Top;
            this.topSearchPanel.Location = new System.Drawing.Point(0, 0);
            this.topSearchPanel.Name = "topSearchPanel";
            this.topSearchPanel.Size = new System.Drawing.Size(1138, 44);
            this.topSearchPanel.TabIndex = 0;
            // 
            // searchOrderBox
            // 
            this.searchOrderBox.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.searchOrderBox.Font = new System.Drawing.Font("Segoe UI", 9F);
            this.searchOrderBox.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.searchOrderBox.Location = new System.Drawing.Point(16, 10);
            this.searchOrderBox.Name = "searchOrderBox";
            this.searchOrderBox.Size = new System.Drawing.Size(340, 23);
            this.searchOrderBox.TabIndex = 0;
            this.searchOrderBox.Text = "";
            this.searchOrderBox.TextChanged += new System.EventHandler(this.SearchOrderBox_TextChanged);
            // 
            // mainContentPanel
            // 
            this.mainContentPanel.BackColor = System.Drawing.Color.White;
            this.mainContentPanel.Controls.Add(this.paymentsGrid);
            this.mainContentPanel.Controls.Add(this.headerAreaPanel);
            this.mainContentPanel.Dock = System.Windows.Forms.DockStyle.Fill;
            this.mainContentPanel.Location = new System.Drawing.Point(0, 44);
            this.mainContentPanel.Name = "mainContentPanel";
            this.mainContentPanel.Padding = new System.Windows.Forms.Padding(16, 12, 16, 16);
            this.mainContentPanel.Size = new System.Drawing.Size(1138, 716);
            this.mainContentPanel.TabIndex = 1;
            // 
            // paymentsGrid
            // 
            this.paymentsGrid.AllowUserToAddRows = false;
            this.paymentsGrid.AllowUserToDeleteRows = false;
            this.paymentsGrid.AllowUserToResizeRows = false;
            this.paymentsGrid.AutoSizeColumnsMode = System.Windows.Forms.DataGridViewAutoSizeColumnsMode.Fill;
            this.paymentsGrid.BackgroundColor = System.Drawing.Color.White;
            this.paymentsGrid.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.paymentsGrid.CellBorderStyle = System.Windows.Forms.DataGridViewCellBorderStyle.SingleHorizontal;
            this.paymentsGrid.ColumnHeadersBorderStyle = System.Windows.Forms.DataGridViewHeaderBorderStyle.Single;
            gridHeaderStyle.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleLeft;
            gridHeaderStyle.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(241)))), ((int)(((byte)(245)))), ((int)(((byte)(249)))));
            gridHeaderStyle.Font = new System.Drawing.Font("Segoe UI", 8.25F, System.Drawing.FontStyle.Bold);
            gridHeaderStyle.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            gridHeaderStyle.Padding = new System.Windows.Forms.Padding(6, 0, 6, 0);
            gridHeaderStyle.SelectionBackColor = System.Drawing.Color.FromArgb(((int)(((byte)(241)))), ((int)(((byte)(245)))), ((int)(((byte)(249)))));
            gridHeaderStyle.SelectionForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            gridHeaderStyle.WrapMode = System.Windows.Forms.DataGridViewTriState.True;
            this.paymentsGrid.ColumnHeadersDefaultCellStyle = gridHeaderStyle;
            this.paymentsGrid.ColumnHeadersHeight = 40;
            this.paymentsGrid.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.DisableResizing;
            this.paymentsGrid.Columns.AddRange(new System.Windows.Forms.DataGridViewColumn[] {
            this.colNo,
            this.colTrxId,
            this.colOrderId,
            this.colItem,
            this.colTotal,
            this.colTime,
            this.colStatus,
            this.colAction});
            gridRowStyle.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleLeft;
            gridRowStyle.BackColor = System.Drawing.Color.White;
            gridRowStyle.Font = new System.Drawing.Font("Segoe UI", 8.5F);
            gridRowStyle.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(51)))), ((int)(((byte)(65)))), ((int)(((byte)(85)))));
            gridRowStyle.Padding = new System.Windows.Forms.Padding(6, 0, 6, 0);
            gridRowStyle.SelectionBackColor = System.Drawing.Color.FromArgb(((int)(((byte)(226)))), ((int)(((byte)(236)))), ((int)(((byte)(255)))));
            gridRowStyle.SelectionForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            gridRowStyle.WrapMode = System.Windows.Forms.DataGridViewTriState.True;
            this.paymentsGrid.DefaultCellStyle = gridRowStyle;
            this.paymentsGrid.Dock = System.Windows.Forms.DockStyle.Fill;
            this.paymentsGrid.EnableHeadersVisualStyles = false;
            this.paymentsGrid.GridColor = System.Drawing.Color.FromArgb(((int)(((byte)(226)))), ((int)(((byte)(232)))), ((int)(((byte)(240)))));
            this.paymentsGrid.Location = new System.Drawing.Point(16, 66);
            this.paymentsGrid.MultiSelect = false;
            this.paymentsGrid.Name = "paymentsGrid";
            this.paymentsGrid.ReadOnly = true;
            this.paymentsGrid.RowHeadersVisible = false;
            this.paymentsGrid.RowTemplate.Height = 48;
            this.paymentsGrid.SelectionMode = System.Windows.Forms.DataGridViewSelectionMode.FullRowSelect;
            this.paymentsGrid.Size = new System.Drawing.Size(1106, 634);
            this.paymentsGrid.TabIndex = 1;
            this.paymentsGrid.CellContentClick += new System.Windows.Forms.DataGridViewCellEventHandler(this.PaymentsGrid_CellContentClick);
            this.paymentsGrid.CellDoubleClick += new System.Windows.Forms.DataGridViewCellEventHandler(this.PaymentsGrid_CellDoubleClick);
            // 
            // colNo
            // 
            noColStyle.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleCenter;
            this.colNo.DefaultCellStyle = noColStyle;
            this.colNo.FillWeight = 36F;
            this.colNo.HeaderText = "No";
            this.colNo.Name = "colNo";
            this.colNo.ReadOnly = true;
            // 
            // colTrxId
            // 
            this.colTrxId.FillWeight = 95F;
            this.colTrxId.HeaderText = "ID Transaksi";
            this.colTrxId.Name = "colTrxId";
            this.colTrxId.ReadOnly = true;
            // 
            // colOrderId
            // 
            this.colOrderId.FillWeight = 95F;
            this.colOrderId.HeaderText = "ID Pesanan";
            this.colOrderId.Name = "colOrderId";
            this.colOrderId.ReadOnly = true;
            // 
            // colItem
            // 
            this.colItem.FillWeight = 155F;
            this.colItem.HeaderText = "Item / Produk";
            this.colItem.Name = "colItem";
            this.colItem.ReadOnly = true;
            // 
            // colTotal
            // 
            priceColStyle.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleRight;
            priceColStyle.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.colTotal.DefaultCellStyle = priceColStyle;
            this.colTotal.FillWeight = 85F;
            this.colTotal.HeaderText = "Total Tagihan";
            this.colTotal.Name = "colTotal";
            this.colTotal.ReadOnly = true;
            // 
            // colTime
            // 
            this.colTime.FillWeight = 100F;
            this.colTime.HeaderText = "Waktu Masuk";
            this.colTime.Name = "colTime";
            this.colTime.ReadOnly = true;
            // 
            // colStatus
            // 
            statusColStyle.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleCenter;
            statusColStyle.Font = new System.Drawing.Font("Segoe UI", 8F, System.Drawing.FontStyle.Bold);
            this.colStatus.DefaultCellStyle = statusColStyle;
            this.colStatus.FillWeight = 95F;
            this.colStatus.HeaderText = "Status";
            this.colStatus.Name = "colStatus";
            this.colStatus.ReadOnly = true;
            // 
            // colAction
            // 
            this.colAction.FillWeight = 75F;
            this.colAction.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.colAction.HeaderText = "Aksi";
            this.colAction.Name = "colAction";
            this.colAction.ReadOnly = true;
            // 
            // headerAreaPanel
            // 
            this.headerAreaPanel.BackColor = System.Drawing.Color.White;
            this.headerAreaPanel.Controls.Add(this.pendingBadgeLabel);
            this.headerAreaPanel.Controls.Add(this.subtitleLabel);
            this.headerAreaPanel.Controls.Add(this.titleLabel);
            this.headerAreaPanel.Dock = System.Windows.Forms.DockStyle.Top;
            this.headerAreaPanel.Location = new System.Drawing.Point(16, 12);
            this.headerAreaPanel.Name = "headerAreaPanel";
            this.headerAreaPanel.Size = new System.Drawing.Size(1106, 54);
            this.headerAreaPanel.TabIndex = 0;
            // 
            // pendingBadgeLabel
            // 
            this.pendingBadgeLabel.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.pendingBadgeLabel.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(238)))), ((int)(((byte)(242)))), ((int)(((byte)(255)))));
            this.pendingBadgeLabel.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.pendingBadgeLabel.Font = new System.Drawing.Font("Segoe UI", 8F, System.Drawing.FontStyle.Bold);
            this.pendingBadgeLabel.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(37)))), ((int)(((byte)(99)))), ((int)(((byte)(235)))));
            this.pendingBadgeLabel.Location = new System.Drawing.Point(956, 6);
            this.pendingBadgeLabel.Name = "pendingBadgeLabel";
            this.pendingBadgeLabel.Size = new System.Drawing.Size(148, 26);
            this.pendingBadgeLabel.TabIndex = 2;
            this.pendingBadgeLabel.Text = "1 Menunggu Persetujuan";
            this.pendingBadgeLabel.TextAlign = System.Drawing.ContentAlignment.MiddleCenter;
            // 
            // subtitleLabel
            // 
            this.subtitleLabel.AutoSize = true;
            this.subtitleLabel.Font = new System.Drawing.Font("Segoe UI", 8.5F);
            this.subtitleLabel.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(100)))), ((int)(((byte)(116)))), ((int)(((byte)(139)))));
            this.subtitleLabel.Location = new System.Drawing.Point(0, 26);
            this.subtitleLabel.Name = "subtitleLabel";
            this.subtitleLabel.Size = new System.Drawing.Size(377, 15);
            this.subtitleLabel.TabIndex = 1;
            this.subtitleLabel.Text = "List of pending transactions awaiting validation of manual bank account transfers.";
            // 
            // titleLabel
            // 
            this.titleLabel.AutoSize = true;
            this.titleLabel.Font = new System.Drawing.Font("Segoe UI", 11F, System.Drawing.FontStyle.Bold);
            this.titleLabel.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.titleLabel.Location = new System.Drawing.Point(0, 2);
            this.titleLabel.Name = "titleLabel";
            this.titleLabel.Size = new System.Drawing.Size(235, 20);
            this.titleLabel.TabIndex = 0;
            this.titleLabel.Text = "Digital Payment Proof Verification";
            // 
            // ManagePaymentsControl
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.BackColor = System.Drawing.Color.White;
            this.Controls.Add(this.mainContentPanel);
            this.Controls.Add(this.topSearchPanel);
            this.Name = "ManagePaymentsControl";
            this.Size = new System.Drawing.Size(1138, 760);
            this.topSearchPanel.ResumeLayout(false);
            this.topSearchPanel.PerformLayout();
            this.mainContentPanel.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)(this.paymentsGrid)).EndInit();
            this.headerAreaPanel.ResumeLayout(false);
            this.headerAreaPanel.PerformLayout();
            this.ResumeLayout(false);
        }

        #endregion
    }
}
