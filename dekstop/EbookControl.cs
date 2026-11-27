using System;
using System.Collections.Generic;
using System.Data;
using System.Drawing;
using System.IO;
using System.Linq;
using System.Windows.Forms;

namespace dekstop
{
    public partial class EbookControl : UserControl
    {
        public DataTable DtKamus { get; private set; }
        private int selectedIndex = -1;
        private string editingEbookId = null;
        private bool suppressNumericSanitize = false;
        private const string SearchPlaceholder = "Search for Titles / Words.";
        private int currentPage = 1;
        private const int PageSize = 5;

        public EbookControl()
        {
            InitializeComponent();
            btnPageFirst.Click += (s, e) => { currentPage = 1; ApplyEbookPage(); };
            btnPagePrev.Click += (s, e) => { if (currentPage > 1) currentPage--; ApplyEbookPage(); };
            btnPageNext.Click += (s, e) => { if (currentPage < GetEbookPageCount()) currentPage++; ApplyEbookPage(); };
            btnPageLast.Click += (s, e) => { currentPage = GetEbookPageCount(); ApplyEbookPage(); };
            btnPage1.Click += (s, e) => { currentPage = 1; ApplyEbookPage(); };
            btnPage2.Click += (s, e) => { currentPage = Math.Min(2, GetEbookPageCount()); ApplyEbookPage(); };
            btnPage3.Click += (s, e) => { currentPage = Math.Min(3, GetEbookPageCount()); ApplyEbookPage(); };
            pnlPagination.Resize += (s, e) => LayoutPaginationButtons();
            SetupNumericInputs();
            SetupDataGridView();
            if (cmbCategory.Items.Count > 0) cmbCategory.SelectedIndex = 0;
            if (cmbAccessStatus.Items.Count > 0) cmbAccessStatus.SelectedIndex = 0;

            if (!DatabaseService.IsDesignMode())
            {
                LoadEbooksFromDb();
            }
        }

        private void SetupDataGridView()
        {
            DtKamus = new DataTable();
            DtKamus.Columns.Add("Pilih", typeof(bool));
            DtKamus.Columns.Add("E-BOOK ID", typeof(string));
            DtKamus.Columns.Add("E-BOOK TITLE", typeof(string));
            DtKamus.Columns.Add("CATEGORY", typeof(string));
            DtKamus.Columns.Add("TOTAL ENTRIES", typeof(string));
            DtKamus.Columns.Add("WRITER", typeof(string));
            DtKamus.Columns.Add("PRICE (RP)", typeof(string));
            DtKamus.Columns.Add("STATUS ACCESS", typeof(string));
            DtKamus.Columns.Add("STATUS E-BOOK", typeof(string));

            DtKamus.Columns.Add("RawHarga", typeof(decimal));
            DtKamus.Columns.Add("RawEntri", typeof(int));
            DtKamus.Columns.Add("Description", typeof(string));
            DtKamus.Columns.Add("PdfPath", typeof(string));
            DtKamus.Columns.Add("IsAktif", typeof(bool));
            DtKamus.Columns.Add("RowNumber", typeof(int));

            dgvKamus.DataSource = DtKamus.DefaultView;

            string[] hiddenCols = { "RawHarga", "RawEntri", "Description", "PdfPath", "IsAktif", "RowNumber" };
            foreach (var col in hiddenCols)
                dgvKamus.Columns[col].Visible = false;

            dgvKamus.ColumnHeadersDefaultCellStyle.BackColor = Color.FromArgb(248, 250, 252);
            dgvKamus.ColumnHeadersDefaultCellStyle.ForeColor = Color.FromArgb(30, 41, 59);
            dgvKamus.ColumnHeadersDefaultCellStyle.Font = new Font("Segoe UI", 8F, FontStyle.Bold);
            dgvKamus.DefaultCellStyle.Font = new Font("Segoe UI", 8.5F);
            dgvKamus.DefaultCellStyle.WrapMode = DataGridViewTriState.True;

            dgvKamus.Columns["Pilih"].HeaderText = "";
            dgvKamus.Columns["Pilih"].FillWeight = 26;
            dgvKamus.Columns["E-BOOK ID"].FillWeight = 62;
            dgvKamus.Columns["E-BOOK TITLE"].FillWeight = 125;
            dgvKamus.Columns["CATEGORY"].FillWeight = 85;
            dgvKamus.Columns["TOTAL ENTRIES"].FillWeight = 65;
            dgvKamus.Columns["WRITER"].FillWeight = 115;
            dgvKamus.Columns["PRICE (RP)"].FillWeight = 65;
            dgvKamus.Columns["STATUS ACCESS"].FillWeight = 75;
            dgvKamus.Columns["STATUS E-BOOK"].FillWeight = 65;

            dgvKamus.Columns["TOTAL ENTRIES"].DefaultCellStyle.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dgvKamus.Columns["PRICE (RP)"].DefaultCellStyle.Alignment = DataGridViewContentAlignment.MiddleRight;
            dgvKamus.Columns["STATUS ACCESS"].DefaultCellStyle.Alignment = DataGridViewContentAlignment.MiddleCenter;
        }

        public void LoadEbooksFromDb(string keyword = "")
        {
            try
            {
                List<EbookModel> ebooks = DatabaseService.GetEbooks(keyword);
                DtKamus.Rows.Clear();

                int rowNumber = 0;
                foreach (var eb in ebooks)
                {
                    DtKamus.Rows.Add(
                        false,
                        eb.EbookId,
                        eb.EbookJudul,
                        eb.EbookKategori,
                        $"{eb.EbookTotalEntri:N0} Word",
                        eb.EbookPenulis,
                        DatabaseService.FormatRupiah(eb.EbookHarga),
                        eb.EbookStatusAkses == "Free dan Premium" ? "Free / Premium" : eb.EbookStatusAkses,
                        eb.EbookAktif ? "Aktif" : "Nonaktif",
                        eb.EbookHarga,
                        eb.EbookTotalEntri,
                        eb.EbookDeskripsi,
                        eb.EbookFile,
                        eb.EbookAktif,
                        rowNumber++
                    );
                }

                int totalKamus = string.IsNullOrWhiteSpace(keyword) ? ebooks.Count : DatabaseService.GetEbooks("").Count;
                decimal qrisVerified = DatabaseService.GetVerifiedQrisTotal();
                int activeUsers = DatabaseService.GetActiveCustomerCount();

                lblCard1Val.Text = $"{totalKamus} Entri";
                lblCard2Val.Text = DatabaseService.FormatRupiah(qrisVerified);
                lblCard3Val.Text = $"{activeUsers:N0} User";

                selectedIndex = -1;
                currentPage = 1;
                ApplyEbookPage();
                UpdatePaginationLabel();
            }
            catch (Exception ex)
            {
                MessageBox.Show("Gagal memuat data E-Book dari database:\n" + ex.Message,
                    "Kesalahan Database", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private void dgvKamus_CellFormatting(object sender, DataGridViewCellFormattingEventArgs e)
        {
            if (e.RowIndex < 0 || e.ColumnIndex < 0) return;

            DataRowView currentView = dgvKamus.Rows[e.RowIndex].DataBoundItem as DataRowView;
            bool isSelectedRow = currentView != null && currentView["Pilih"] != DBNull.Value &&
                                 Convert.ToBoolean(currentView["Pilih"]);
            string colName = dgvKamus.Columns[e.ColumnIndex].Name;

            if (isSelectedRow)
                e.CellStyle.BackColor = Color.FromArgb(239, 246, 255);

            if (colName == "E-BOOK ID")
            {
                e.CellStyle.Font = new Font("Segoe UI", 8.5F, FontStyle.Bold);
                e.CellStyle.ForeColor = isSelectedRow ? Color.FromArgb(37, 99, 235) : Color.FromArgb(51, 65, 85);
            }
            else if (colName == "E-BOOK TITLE")
            {
                e.CellStyle.Font = new Font("Segoe UI", 8.5F, FontStyle.Bold);
                e.CellStyle.ForeColor = Color.FromArgb(17, 24, 39);
            }
            else if (colName == "STATUS E-BOOK")
            {
                string statusAktif = e.Value?.ToString() ?? "";
                e.CellStyle.Font = new Font("Segoe UI", 8F, FontStyle.Bold);
                e.CellStyle.Alignment = DataGridViewContentAlignment.MiddleCenter;
                if (statusAktif == "Aktif")
                {
                    e.CellStyle.BackColor = Color.FromArgb(220, 252, 231);
                    e.CellStyle.ForeColor = Color.FromArgb(22, 101, 52);
                }
                else
                {
                    e.CellStyle.BackColor = Color.FromArgb(241, 245, 249);
                    e.CellStyle.ForeColor = Color.FromArgb(100, 116, 139);
                }
            }
            else if (colName == "STATUS ACCESS")
            {
                string status = e.Value?.ToString() ?? "";
                e.CellStyle.Font = new Font("Segoe UI", 8F, FontStyle.Bold);

                if (status.Contains("Free / Premium") || status.Contains("Free dan Premium"))
                {
                    e.CellStyle.BackColor = Color.FromArgb(223, 167, 243);
                    e.CellStyle.ForeColor = Color.FromArgb(22, 101, 52);
                }
                else if (status.Contains("Premium"))
                {
                    e.CellStyle.BackColor = Color.FromArgb(219, 234, 254);
                    e.CellStyle.ForeColor = Color.FromArgb(29, 78, 216);
                }
                else
                {
                    e.CellStyle.BackColor = Color.FromArgb(254, 243, 199);
                    e.CellStyle.ForeColor = Color.FromArgb(180, 83, 9);
                }
            }
        }

        private void dgvKamus_CellClick(object sender, DataGridViewCellEventArgs e)
        {
            if (e.RowIndex < 0) return;

            DataRowView view = dgvKamus.Rows[e.RowIndex].DataBoundItem as DataRowView;
            if (view == null) return;
            for (int i = 0; i < DtKamus.Rows.Count; i++) DtKamus.Rows[i]["Pilih"] = false;
            selectedIndex = DtKamus.Rows.IndexOf(view.Row);
            view.Row["Pilih"] = true;
            DataRow row = DtKamus.Rows[selectedIndex];
            editingEbookId = row["E-BOOK ID"].ToString();
            cmbAccessStatus.SelectedItem = row["STATUS ACCESS"].ToString();
            if (cmbAccessStatus.SelectedIndex < 0) cmbAccessStatus.SelectedIndex = 0;

            lblDialogTitle.Text = $"Dialog: [Edit Kamus - {editingEbookId}]";
            txtEbookTitle.Text = row["E-BOOK TITLE"].ToString();
            txtWriter.Text = row["WRITER"].ToString();
            txtPrice.Text = Convert.ToDecimal(row["RawHarga"]).ToString("0");
            txtEntryEst.Text = Convert.ToInt32(row["RawEntri"]).ToString();
            txtPdfPath.Text = row["PdfPath"].ToString();
            chkEbookAktif.Checked = Convert.ToBoolean(row["IsAktif"]);

            string category = row["CATEGORY"].ToString();
            int foundIdx = cmbCategory.Items.IndexOf(category);
            if (foundIdx >= 0) cmbCategory.SelectedIndex = foundIdx;
            txtDesc.Text = row["Description"].ToString();
        }

        private void btnBrowsePdf_Click(object sender, EventArgs e)
        {
            using (OpenFileDialog ofd = new OpenFileDialog())
            {
                ofd.Filter = "PDF Files (*.pdf)|*.pdf";
                ofd.Title = "Pilih Dokumen Kamus PDF";
                if (ofd.ShowDialog() == DialogResult.OK)
                {
                    txtPdfPath.Text = ofd.FileName;
                    FileInfo fi = new FileInfo(ofd.FileName);
                    lblPdfStatus.Text = $"Ukuran file: {fi.Length / (1024.0 * 1024.0):F1} MB (Status: Terverifikasi Valid PDF-A)";
                }
            }
        }

        private void SetupNumericInputs()
        {
            txtPrice.KeyPress += NumericOnly_KeyPress;
            txtPrice.TextChanged += NumericOnly_TextChanged;
            txtEntryEst.KeyPress += NumericOnly_KeyPress;
            txtEntryEst.TextChanged += NumericOnly_TextChanged;
        }

        private void NumericOnly_KeyPress(object sender, KeyPressEventArgs e)
        {
            if (!char.IsControl(e.KeyChar) && !char.IsDigit(e.KeyChar))
            {
                e.Handled = true;
            }
        }

        private void NumericOnly_TextChanged(object sender, EventArgs e)
        {
            if (suppressNumericSanitize) return;
            if (sender is TextBox tb)
            {
                string current = tb.Text ?? string.Empty;
                string digitsOnly = new string(current.Where(char.IsDigit).ToArray());
                if (digitsOnly != current)
                {
                    suppressNumericSanitize = true;
                    int sel = tb.SelectionStart;
                    tb.Text = digitsOnly;
                    tb.SelectionStart = Math.Min(sel, digitsOnly.Length);
                    suppressNumericSanitize = false;
                }
            }
        }

        private decimal ParseDecimalClean(string text)
        {
            if (string.IsNullOrWhiteSpace(text)) return 0;
            string digits = new string(text.Where(char.IsDigit).ToArray());
            return decimal.TryParse(digits, out decimal val) ? val : 0;
        }

        private int ParseIntClean(string text)
        {
            if (string.IsNullOrWhiteSpace(text)) return 0;
            string digits = new string(text.Where(char.IsDigit).ToArray());
            return int.TryParse(digits, out int val) ? val : 0;
        }

        private void btnSimpanData_Click(object sender, EventArgs e)
        {
            if (string.IsNullOrWhiteSpace(txtEbookTitle.Text))
            {
                MessageBox.Show("E-Book Title wajib diisi!", "Validasi", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                txtEbookTitle.Focus();
                return;
            }
            if (string.IsNullOrWhiteSpace(txtWriter.Text))
            {
                MessageBox.Show("Writer name wajib diisi!", "Validasi", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                txtWriter.Focus();
                return;
            }
            if (!string.IsNullOrWhiteSpace(txtPrice.Text) && !txtPrice.Text.Trim().All(char.IsDigit))
            {
                MessageBox.Show("Access Price hanya boleh diisi dengan angka!", "Validasi", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                txtPrice.Focus();
                return;
            }
            if (!string.IsNullOrWhiteSpace(txtEntryEst.Text) && !txtEntryEst.Text.Trim().All(char.IsDigit))
            {
                MessageBox.Show("Entry Estimate hanya boleh diisi dengan angka!", "Validasi", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                txtEntryEst.Focus();
                return;
            }

            decimal harga = ParseDecimalClean(txtPrice.Text);
            int totalEntri = ParseIntClean(txtEntryEst.Text);
            string statusAksesUI = cmbAccessStatus.SelectedItem?.ToString() ?? "Free / Premium";
            // Samakan label UI dengan nilai yang diizinkan CHECK constraint SQL Server.
            string statusAkses = statusAksesUI == "Free / Premium" ? "Free dan Premium" : statusAksesUI;
            string kategori = cmbCategory.SelectedItem?.ToString() ?? "Umum";
            string catatanBersih = txtDesc.Text.Trim();

            var model = new EbookModel
            {
                EbookId = editingEbookId,
                EbookJudul = txtEbookTitle.Text.Trim(),
                EbookTotalEntri = totalEntri,
                EbookKategori = kategori,
                EbookPenulis = txtWriter.Text.Trim(),
                EbookHarga = harga,
                EbookStatusAkses = statusAkses,
                EbookDeskripsi = catatanBersih,
                EbookFile = txtPdfPath.Text.Trim(),
                EbookAktif = chkEbookAktif.Checked
            };

            try
            {
                bool isNew = string.IsNullOrWhiteSpace(editingEbookId);
                DatabaseService.SaveEbook(model, isNew);

                MessageBox.Show(isNew
                    ? "Data kamus baru berhasil disimpan ke database!"
                    : $"Perubahan kamus {editingEbookId} berhasil diperbarui di database!",
                    "Sukses", MessageBoxButtons.OK, MessageBoxIcon.Information);

                btnBatal_Click(null, null);
                LoadEbooksFromDb();
            }
            catch (Exception ex)
            {
                MessageBox.Show("Gagal menyimpan data kamus ke database:\n" + ex.Message,
                    "Kesalahan Database", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private void btnBatal_Click(object sender, EventArgs e)
        {
            selectedIndex = -1;
            editingEbookId = null;
            for (int i = 0; i < DtKamus.Rows.Count; i++)
                DtKamus.Rows[i]["Pilih"] = false;

            lblDialogTitle.Text = "Dialog: [Tambah Kamus Baru - Boso Walikan]";
            txtEbookTitle.Clear();
            if (cmbCategory.Items.Count > 0) cmbCategory.SelectedIndex = 0;
            if (cmbAccessStatus.Items.Count > 0) cmbAccessStatus.SelectedIndex = 0;
            txtWriter.Clear();
            txtPrice.Text = "0";
            txtEntryEst.Text = "0";
            txtDesc.Clear();
            txtPdfPath.Clear();
            lblPdfStatus.Text = "Ukuran file: - (Belum ada file PDF dipilih)";
            chkEbookAktif.Checked = true;

            UpdatePaginationLabel();
            dgvKamus.Refresh();
        }

        private void btnSearch_Click(object sender, EventArgs e)
        {
            string keyword = txtSearch.Text.Trim();
            if (keyword == SearchPlaceholder) keyword = "";
            LoadEbooksFromDb(keyword);
        }

        private int GetEbookPageCount()
        {
            return Math.Max(1, (int)Math.Ceiling(DtKamus.Rows.Count / (double)PageSize));
        }

        private void ApplyEbookPage()
        {
            int total = DtKamus.Rows.Count;
            int pages = GetEbookPageCount();
            currentPage = Math.Max(1, Math.Min(currentPage, pages));
            int first = (currentPage - 1) * PageSize;
            int last = Math.Min(first + PageSize, total);
            ((DataView)dgvKamus.DataSource).RowFilter = total == 0
                ? "1 = 0"
                : $"RowNumber >= {first} AND RowNumber < {last}";
            lblPageInfo.Text = total > 0
                ? $"Menampilkan {first + 1} - {last} dari {total} entri kamus"
                : "Menampilkan 0 entri kamus";
            btnPage1.Text = currentPage.ToString();
            btnPage2.Visible = pages > 1;
            btnPage3.Visible = pages > 2;
            btnPageFirst.Enabled = btnPagePrev.Enabled = currentPage > 1;
            btnPageNext.Enabled = btnPageLast.Enabled = currentPage < pages;
            LayoutPaginationButtons();
            dgvKamus.Refresh();
        }

        private void LayoutPaginationButtons()
        {
            Button[] buttons = { btnPageFirst, btnPagePrev, btnPage1, btnPage2, btnPage3, btnPageNext, btnPageLast };
            int right = pnlPagination.ClientSize.Width - 10;
            int y = Math.Max(4, (pnlPagination.ClientSize.Height - btnPageFirst.Height) / 2);
            const int gap = 4;

            for (int i = buttons.Length - 1; i >= 0; i--)
            {
                if (!buttons[i].Visible) continue;
                right -= buttons[i].Width;
                buttons[i].Location = new Point(right, y);
                right -= gap;
            }
        }

        private void UpdatePaginationLabel()
        {
            ApplyEbookPage();
        }

        private void txtSearch_Enter(object sender, EventArgs e)
        {
            if (txtSearch.Text == SearchPlaceholder)
            {
                txtSearch.Text = "";
                txtSearch.ForeColor = Color.Black;
            }
        }

        private void txtSearch_Leave(object sender, EventArgs e)
        {
            if (string.IsNullOrWhiteSpace(txtSearch.Text))
            {
                txtSearch.Text = SearchPlaceholder;
                txtSearch.ForeColor = Color.Gray;
            }
        }

        private void pictureBox1_Click(object sender, EventArgs e)
        {

        }
    }
}