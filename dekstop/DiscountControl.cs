using System;
using System.Collections.Generic;
using System.Data;
using System.Drawing;
using System.Globalization;
using System.Linq;
using System.Windows.Forms;

namespace dekstop
{
    public partial class DiscountControl : UserControl
    {
        private DataTable dtDiskon;
        private int selectedIndex = -1;
        private string editingDiskonId = null;
        private bool suppressNilaiSanitize = false;
        private DateTimePicker dtpMulaiBerlaku;
        private int currentPage = 1;
        private const int PageSize = 5;
        private const string SearchPlaceholder = "Look for a voucher code or discount details...";
        private static readonly CultureInfo IdCulture = new CultureInfo("id-ID");

        public DiscountControl()
        {
            InitializeComponent();
            btnPageFirst.Click += (s, e) => { currentPage = 1; ApplyDiscountPage(); };
            btnPagePrev.Click += (s, e) => { if (currentPage > 1) currentPage--; ApplyDiscountPage(); };
            btnPageNext.Click += (s, e) => { if (currentPage < GetDiscountPageCount()) currentPage++; ApplyDiscountPage(); };
            btnPageLast.Click += (s, e) => { currentPage = GetDiscountPageCount(); ApplyDiscountPage(); };
            btnPage1.Click += (s, e) => { currentPage = 1; ApplyDiscountPage(); };
            SetupNilaiValidation();
            SetupMinimalValidation();
            SetupDataGridView();
            if (cmbTipe.Items.Count > 0) cmbTipe.SelectedIndex = 0;
            dtpMulaiBerlaku = new DateTimePicker { Format = DateTimePickerFormat.Custom, CustomFormat = "dd MMMM yyyy", Font = new System.Drawing.Font("Segoe UI", 9F), Location = new Point(14, 274), Size = new Size(398, 27), Value = DateTime.Today };
            var lblMulai = new Label { Text = "Mulai Berlaku", AutoSize = true, Font = new System.Drawing.Font("Segoe UI", 8.5F, FontStyle.Bold), Location = new Point(14, 254) };
            pnlDialogBody.Controls.Add(lblMulai);
            pnlDialogBody.Controls.Add(dtpMulaiBerlaku);
            dtpMulaiBerlaku.BringToFront(); lblMulai.BringToFront();
            DateTime defaultExpiry = DateTime.Now.AddMonths(1).Date.AddHours(23).AddMinutes(59);
            dtpMasaBerlaku.Value = defaultExpiry;
            dtpJamBerlaku.Value = defaultExpiry;

            if (!DatabaseService.IsDesignMode())
            {
                LoadDiskonsFromDb();
            }
        }

        private void SetupDataGridView()
        {
            dtDiskon = new DataTable();
            dtDiskon.Columns.Add("Pilih", typeof(bool));
            dtDiskon.Columns.Add("DISCOUNT ID", typeof(string));
            dtDiskon.Columns.Add("JENIS POTONGAN", typeof(string));
            dtDiskon.Columns.Add("NILAI DISKON", typeof(string));
            dtDiskon.Columns.Add("MIN. TRANSAKSI", typeof(string));
            dtDiskon.Columns.Add("MASA BERLAKU", typeof(string));
            dtDiskon.Columns.Add("STATUS", typeof(string));
            dtDiskon.Columns.Add("AKSI", typeof(string));
            dtDiskon.Columns.Add("NilaiRaw", typeof(decimal));
            dtDiskon.Columns.Add("MinTransaksiRaw", typeof(decimal));
            dtDiskon.Columns.Add("MulaiRaw", typeof(DateTime));
            dtDiskon.Columns.Add("AkhirRaw", typeof(DateTime));
            dtDiskon.Columns.Add("Catatan", typeof(string));
            dtDiskon.Columns.Add("IsAktifRaw", typeof(bool));
            dtDiskon.Columns.Add("RowNumber", typeof(int));
            dgvDiskon.DataSource = dtDiskon.DefaultView;
            foreach (string col in new[] { "NilaiRaw", "MinTransaksiRaw", "MulaiRaw", "AkhirRaw", "Catatan", "IsAktifRaw", "RowNumber" }) dgvDiskon.Columns[col].Visible = false;
            dgvDiskon.ColumnHeadersDefaultCellStyle.BackColor = Color.FromArgb(248, 250, 252);
            dgvDiskon.ColumnHeadersDefaultCellStyle.ForeColor = Color.FromArgb(30, 41, 59);
            dgvDiskon.ColumnHeadersDefaultCellStyle.Font = new Font("Segoe UI", 8F, FontStyle.Bold);
            dgvDiskon.DefaultCellStyle.Font = new Font("Segoe UI", 8.5F);
            dgvDiskon.DefaultCellStyle.WrapMode = DataGridViewTriState.True;
            dgvDiskon.Columns["Pilih"].HeaderText = "";
            dgvDiskon.Columns["Pilih"].FillWeight = 25;
            dgvDiskon.Columns["DISCOUNT ID"].FillWeight = 90;
            dgvDiskon.Columns["JENIS POTONGAN"].FillWeight = 95;
            dgvDiskon.Columns["NILAI DISKON"].FillWeight = 75;
            dgvDiskon.Columns["MIN. TRANSAKSI"].FillWeight = 95;
            dgvDiskon.Columns["MASA BERLAKU"].FillWeight = 120;
            dgvDiskon.Columns["STATUS"].FillWeight = 65;
            dgvDiskon.Columns["AKSI"].FillWeight = 55;
            dgvDiskon.Columns["NILAI DISKON"].DefaultCellStyle.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dgvDiskon.Columns["STATUS"].DefaultCellStyle.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dgvDiskon.Columns["AKSI"].DefaultCellStyle.Alignment = DataGridViewContentAlignment.MiddleCenter;
        }

        public void LoadDiskonsFromDb(string keyword = "")
        {
            try
            {
                List<DiskonModel> list = DatabaseService.GetDiskons(keyword);
                dtDiskon.Rows.Clear(); int activeCount = 0; int scheduledCount = 0; int rowNumber = 0;
                foreach (var d in list)
                {
                    DateTime mulai = d.DiskonMulaiBerlaku ?? DateTime.MinValue;
                    DateTime akhir = d.DiskonMasaBerlaku ?? DateTime.MaxValue;
                    bool notStarted = mulai > DateTime.Now; bool expired = akhir < DateTime.Now;
                    string status = !d.DiskonAktif || expired ? "Nonaktif" : notStarted ? "Terjadwal" : "Aktif";
                    if (status == "Aktif") activeCount++; if (status == "Terjadwal") scheduledCount++;
                    bool percent = d.DiskonJenis.Contains("%") || d.DiskonJenis.IndexOf("Persen", StringComparison.OrdinalIgnoreCase) >= 0;
                    string nilai = percent ? $"{d.DiskonNilai:0.##}%" : DatabaseService.FormatRupiah(d.DiskonNilai);
                    string min = d.DiskonMinimalTransaksi.HasValue && d.DiskonMinimalTransaksi.Value > 0 ? DatabaseService.FormatRupiah(d.DiskonMinimalTransaksi.Value) : "Tanpa Min";
                    dtDiskon.Rows.Add(false,d.DiskonId,d.DiskonJenis,nilai,min,
                        $"{mulai:dd MMM yyyy} – {akhir:dd MMM yyyy HH:mm}",status,"Edit\nHapus",
                        d.DiskonNilai,d.DiskonMinimalTransaksi ?? 0m,mulai,akhir,d.DiskonCatatan,d.DiskonAktif,rowNumber++);
                }
                lblCard1Val.Text = $"{activeCount} Aktif";
                lblCard2Val.Text = $"{list.Count} Voucher";
                lblCard3Val.Text = $"{scheduledCount} Terjadwal";
                selectedIndex=-1; editingDiskonId=null; currentPage=1; ApplyDiscountPage(); btnBatal_Click(null,null); UpdatePaginationLabel();
            }
            catch(Exception ex)
            {
                MessageBox.Show("Gagal memuat data diskon dari database:\n"+ex.Message,"Kesalahan Database",MessageBoxButtons.OK,MessageBoxIcon.Error);
            }
        }

        private void dgvDiskon_CellFormatting(object sender, DataGridViewCellFormattingEventArgs e)
        {
            if (e.RowIndex < 0 || e.ColumnIndex < 0) return;

            DataRowView currentView = dgvDiskon.Rows[e.RowIndex].DataBoundItem as DataRowView;
            bool isSelectedRow = currentView != null && currentView["Pilih"] != DBNull.Value &&
                                 Convert.ToBoolean(currentView["Pilih"]);
            string colName = dgvDiskon.Columns[e.ColumnIndex].Name;

            if (isSelectedRow)
                e.CellStyle.BackColor = Color.FromArgb(239, 246, 255);

            if (colName == "DISCOUNT ID" || colName == "NILAI DISKON")
            {
                e.CellStyle.Font = new Font("Segoe UI", 8.5F, FontStyle.Bold);
                e.CellStyle.ForeColor = isSelectedRow ? Color.FromArgb(37, 99, 235) : Color.FromArgb(17, 24, 39);
            }
            else if (colName == "STATUS")
            {
                string status = e.Value?.ToString() ?? "";
                e.CellStyle.Font = new Font("Segoe UI", 8F, FontStyle.Bold);
                if (status == "Aktif")
                {
                    e.CellStyle.BackColor = Color.FromArgb(220, 252, 231);
                    e.CellStyle.ForeColor = Color.FromArgb(22, 101, 52);
                }
                else if (status == "Terjadwal")
                {
                    e.CellStyle.BackColor = Color.FromArgb(219, 234, 254);
                    e.CellStyle.ForeColor = Color.FromArgb(30, 64, 175);
                }
                else
                {
                    e.CellStyle.BackColor = Color.FromArgb(241, 245, 249);
                    e.CellStyle.ForeColor = Color.FromArgb(100, 116, 139);
                }
            }
            else if (colName == "AKSI")
            {
                e.CellStyle.Font = new Font("Segoe UI", 8F, FontStyle.Bold);
                e.CellStyle.ForeColor = Color.FromArgb(37, 99, 235);
            }
        }

        private void dgvDiskon_CellClick(object sender, DataGridViewCellEventArgs e)
        {
            if (e.RowIndex < 0) return;

            DataRowView view = dgvDiskon.Rows[e.RowIndex].DataBoundItem as DataRowView;
            if (view == null) return;
            int actualIndex = dtDiskon.Rows.IndexOf(view.Row);
            if (dgvDiskon.Columns[e.ColumnIndex].Name == "AKSI")
            {
                Rectangle cell = dgvDiskon.GetCellDisplayRectangle(e.ColumnIndex, e.RowIndex, false);
                Point mouse = dgvDiskon.PointToClient(Cursor.Position);
                string id = view["DISCOUNT ID"].ToString();
                if (mouse.Y - cell.Y >= cell.Height / 2)
                {
                    if (MessageBox.Show($"Hapus voucher diskon {id}?", "Konfirmasi Hapus", MessageBoxButtons.YesNo, MessageBoxIcon.Question) == DialogResult.Yes)
                    {
                        try { DatabaseService.DeleteDiskon(id); LoadDiskonsFromDb(); }
                        catch (Exception ex) { MessageBox.Show("Gagal menghapus diskon:\\n" + ex.Message, "Kesalahan Database", MessageBoxButtons.OK, MessageBoxIcon.Error); }
                    }
                    return;
                }
                selectedIndex = actualIndex;
                LoadRowToDialog(actualIndex);
                return;
            }
            for (int i = 0; i < dtDiskon.Rows.Count; i++) dtDiskon.Rows[i]["Pilih"] = (i == actualIndex);
            selectedIndex = actualIndex;
            LoadRowToDialog(selectedIndex);
            dgvDiskon.Refresh();
        }

        private void LoadRowToDialog(int index)
        {
            if (index < 0 || index >= dtDiskon.Rows.Count) return;

            DataRow row = dtDiskon.Rows[index];
            string kode = row["DISCOUNT ID"].ToString();
            editingDiskonId = kode;

            lblDialogTitle.Text = $"Dialog: [Edit Diskon - {kode}]";
            txtKode.Text = kode;
            txtKode.ReadOnly = true;

            string jenis = row["JENIS POTONGAN"].ToString();
            cmbTipe.SelectedIndex = (jenis.Contains("%") || jenis.IndexOf("Persen", StringComparison.OrdinalIgnoreCase) >= 0) ? 0 : 1;

            txtNilai.Text = Convert.ToDecimal(row["NilaiRaw"]).ToString("0");

            decimal minBeli = Convert.ToDecimal(row["MinTransaksiRaw"]);
            txtMinBeli.Text = minBeli.ToString("0", CultureInfo.InvariantCulture);

            DateTime mulai = Convert.ToDateTime(row["MulaiRaw"]);
            DateTime berlaku = Convert.ToDateTime(row["AkhirRaw"]);
            if (mulai < dtpMulaiBerlaku.MinDate) mulai = dtpMulaiBerlaku.MinDate;
            if (mulai > dtpMulaiBerlaku.MaxDate) mulai = dtpMulaiBerlaku.MaxDate;
            if (berlaku < dtpMasaBerlaku.MinDate) berlaku = dtpMasaBerlaku.MinDate;
            if (berlaku > dtpMasaBerlaku.MaxDate) berlaku = dtpMasaBerlaku.MaxDate;
            dtpMulaiBerlaku.Value = mulai.Date;
            dtpMasaBerlaku.Value = berlaku.Date;
            dtpJamBerlaku.Value = DateTime.Today.Add(berlaku.TimeOfDay);
            chkAktif.Checked = Convert.ToBoolean(row["IsAktifRaw"]);
            txtCatatan.Text = row["Catatan"].ToString();
        }

        private bool IsPercentDiscountType()
        {
            if (cmbTipe.SelectedIndex == 0) return true;
            string selected = cmbTipe.SelectedItem?.ToString() ?? string.Empty;
            return selected.Contains("%") || selected.IndexOf("Persen", StringComparison.OrdinalIgnoreCase) >= 0;
        }

        private void SetupNilaiValidation()
        {
            txtNilai.KeyPress += TxtNilai_KeyPress;
            txtNilai.TextChanged += TxtNilai_TextChanged;
        }

        private void TxtNilai_KeyPress(object sender, KeyPressEventArgs e)
        {
            if (!char.IsControl(e.KeyChar) && !char.IsDigit(e.KeyChar))
            {
                e.Handled = true;
            }
        }

        private void TxtNilai_TextChanged(object sender, EventArgs e)
        {
            if (suppressNilaiSanitize) return;

            string current = txtNilai.Text ?? string.Empty;
            string digitsOnly = new string(current.Where(char.IsDigit).ToArray());

            if (IsPercentDiscountType() && decimal.TryParse(digitsOnly, out decimal pctVal) && pctVal > 100m)
            {
                digitsOnly = "100";
            }

            if (digitsOnly != current)
            {
                suppressNilaiSanitize = true;
                int sel = txtNilai.SelectionStart;
                txtNilai.Text = digitsOnly;
                txtNilai.SelectionStart = Math.Min(sel, digitsOnly.Length);
                suppressNilaiSanitize = false;
            }
        }

        private void cmbTipe_SelectedIndexChanged(object sender, EventArgs e)
        {
            bool isPercent = IsPercentDiscountType();
            lblSuffix.Text = isPercent ? "%" : "Rp";
            if (isPercent)
            {
                decimal val = ParseDecimalClean(txtNilai.Text);
                if (val > 100m)
                {
                    suppressNilaiSanitize = true;
                    txtNilai.Text = "100";
                    txtNilai.SelectionStart = txtNilai.Text.Length;
                    suppressNilaiSanitize = false;
                }
            }
        }

        private void SetupMinimalValidation()
        {
            txtMinBeli.Text = "0";
            txtMinBeli.KeyPress += (sender, e) =>
            {
                if (!char.IsControl(e.KeyChar) && !char.IsDigit(e.KeyChar)) e.Handled = true;
            };
            txtMinBeli.TextChanged += (sender, e) =>
            {
                string digits = new string((txtMinBeli.Text ?? string.Empty).Where(char.IsDigit).ToArray());
                if (digits != txtMinBeli.Text)
                {
                    int pos = txtMinBeli.SelectionStart;
                    txtMinBeli.Text = digits;
                    txtMinBeli.SelectionStart = Math.Min(pos, txtMinBeli.Text.Length);
                }
            };
        }

        private decimal ParseDecimalClean(string text)
        {
            if (string.IsNullOrWhiteSpace(text)) return 0;
            string digits = new string(text.Where(char.IsDigit).ToArray());
            return decimal.TryParse(digits, out decimal val) ? val : 0;
        }

        private DateTime ParseDateFlexible(string input)
        {
            if (DateTime.TryParse(input, IdCulture, DateTimeStyles.None, out DateTime dt))
                return dt;
            if (DateTime.TryParse(input, CultureInfo.InvariantCulture, DateTimeStyles.None, out DateTime dtInv))
                return dtInv;
            return DateTime.Now.AddMonths(1);
        }

        private void btnSimpanDiskon_Click(object sender, EventArgs e)
        {
            string kode = txtKode.Text.Trim().ToUpperInvariant();
            if (string.IsNullOrWhiteSpace(kode))
            {
                MessageBox.Show("Kode Diskon wajib diisi!", "Validasi", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                txtKode.Focus();
                return;
            }

            decimal nilai = ParseDecimalClean(txtNilai.Text);
            if (nilai <= 0)
            {
                MessageBox.Show("Nilai potongan harus lebih dari 0!", "Validasi", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                txtNilai.Focus();
                return;
            }

            if (IsPercentDiscountType() && nilai > 100m)
            {
                MessageBox.Show("Nilai potongan persentase (%) tidak boleh melebihi 100%!", "Validasi", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                txtNilai.Text = "100";
                txtNilai.Focus();
                return;
            }

            if (string.IsNullOrWhiteSpace(txtMinBeli.Text) || !txtMinBeli.Text.All(char.IsDigit))
            {
                MessageBox.Show("Minimal pembelian hanya boleh diisi angka (0 jika tanpa minimum).", "Validasi", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                txtMinBeli.Focus(); return;
            }
            decimal minBeli = ParseDecimalClean(txtMinBeli.Text);
            DateTime masaBerlaku = dtpMasaBerlaku.Value.Date.Add(dtpJamBerlaku.Value.TimeOfDay);
            if (masaBerlaku <= dtpMulaiBerlaku.Value.Date)
            {
                MessageBox.Show("Masa berlaku akhir harus setelah tanggal mulai berlaku.", "Validasi", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                dtpMasaBerlaku.Focus(); return;
            }

            var model = new DiskonModel
            {
                DiskonId = kode,
                // UI label dinormalisasi ke nilai yang diizinkan CHECK constraint CK_diskon_jenis.
                DiskonJenis = IsPercentDiscountType() ? "Persentase" : "Nominal",
                DiskonNilai = nilai,
                DiskonMinimalTransaksi = minBeli,
                DiskonMulaiBerlaku = dtpMulaiBerlaku.Value.Date,
                DiskonMasaBerlaku = masaBerlaku,
                DiskonAktif = chkAktif.Checked,
                DiskonCatatan = txtCatatan.Text.Trim()
            };

            try
            {
                bool isNew = string.IsNullOrWhiteSpace(editingDiskonId);
                DatabaseService.SaveDiskon(model, isNew);

                MessageBox.Show(isNew
                    ? $"Voucher diskon {kode} berhasil ditambahkan ke database!"
                    : $"Perubahan voucher {kode} berhasil disimpan ke database!",
                    "Sukses", MessageBoxButtons.OK, MessageBoxIcon.Information);

                LoadDiskonsFromDb();
            }
            catch (Exception ex)
            {
                MessageBox.Show("Gagal menyimpan data diskon ke database:\n" + ex.Message,
                    "Kesalahan Database", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private void btnHapusDiskon_Click(object sender, EventArgs e)
        {
            string targetId = editingDiskonId ?? txtKode.Text.Trim();
            if (string.IsNullOrWhiteSpace(targetId))
            {
                MessageBox.Show("Pilih voucher diskon yang akan dihapus terlebih dahulu.", "Info", MessageBoxButtons.OK, MessageBoxIcon.Information);
                return;
            }

            if (MessageBox.Show($"Hapus voucher diskon {targetId} secara permanen dari database?", "Konfirmasi Hapus",
                MessageBoxButtons.YesNo, MessageBoxIcon.Question) == DialogResult.Yes)
            {
                try
                {
                    DatabaseService.DeleteDiskon(targetId);
                    MessageBox.Show($"Voucher {targetId} berhasil dihapus.", "Sukses", MessageBoxButtons.OK, MessageBoxIcon.Information);
                    LoadDiskonsFromDb();
                }
                catch (Exception ex)
                {
                    MessageBox.Show("Gagal menghapus diskon (mungkin sudah digunakan pada transaksi):\n" + ex.Message,
                        "Kesalahan Database", MessageBoxButtons.OK, MessageBoxIcon.Error);
                }
            }
        }

        private void btnBatal_Click(object sender, EventArgs e)
        {
            selectedIndex = -1;
            editingDiskonId = null;
            for (int i = 0; i < dtDiskon.Rows.Count; i++)
                dtDiskon.Rows[i]["Pilih"] = false;

            lblDialogTitle.Text = "Dialog: [Tambah Diskon - BARU]";
            txtKode.ReadOnly = false;
            txtKode.Clear();
            if (cmbTipe.Items.Count > 0) cmbTipe.SelectedIndex = 0;
            txtNilai.Clear();
            txtMinBeli.Text = "0";
            DateTime defaultExpiry = DateTime.Now.AddMonths(1).Date.AddHours(23).AddMinutes(59);
            dtpMasaBerlaku.Value = defaultExpiry;
            dtpJamBerlaku.Value = defaultExpiry;
            dtpMulaiBerlaku.Value = DateTime.Today;
            chkAktif.Checked = true;
            txtCatatan.Clear();
            dgvDiskon.Refresh();
        }

        private void btnSearch_Click(object sender, EventArgs e)
        {
            string keyword = txtSearch.Text.Trim();
            if (keyword == SearchPlaceholder) keyword = "";
            LoadDiskonsFromDb(keyword);
        }

        private int GetDiscountPageCount()
        {
            return Math.Max(1, (int)Math.Ceiling(dtDiskon.Rows.Count / (double)PageSize));
        }

        private void ApplyDiscountPage()
        {
            int total = dtDiskon.Rows.Count;
            int pages = GetDiscountPageCount();
            currentPage = Math.Max(1, Math.Min(currentPage, pages));
            int first = (currentPage - 1) * PageSize;
            int last = Math.Min(first + PageSize, total);
            ((DataView)dgvDiskon.DataSource).RowFilter = total == 0
                ? "1 = 0"
                : $"RowNumber >= {first} AND RowNumber < {last}";
            btnPage1.Text = currentPage.ToString();
            lblPageInfo.Text = total == 0 ? "Tidak ada data diskon" :
                $"Menampilkan {first + 1} - {last} dari {total} diskon";
            btnPageFirst.Enabled = btnPagePrev.Enabled = currentPage > 1;
            btnPageNext.Enabled = btnPageLast.Enabled = currentPage < pages;
            dgvDiskon.Refresh();
        }

        private void UpdatePaginationLabel()
        {
            ApplyDiscountPage();
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
    }
}