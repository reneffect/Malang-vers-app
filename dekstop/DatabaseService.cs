using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Data.SqlClient;
using System.Globalization;
using System.Linq;
using System.Text;

namespace dekstop
{
    public static class UserSession
    {
        public static string UserId { get; set; } = string.Empty;
        public static string Nama { get; set; } = string.Empty;
        public static string Username { get; set; } = string.Empty;
        public static string Role { get; set; } = string.Empty;

        public static bool IsLoggedIn => !string.IsNullOrWhiteSpace(UserId);

        public static void Clear()
        {
            UserId = string.Empty;
            Nama = string.Empty;
            Username = string.Empty;
            Role = string.Empty;
        }
    }

    public class UserModel
    {
        public string UserId { get; set; }
        public string UserNama { get; set; }
        public string UserUsername { get; set; }
        public string UserRole { get; set; }
        public string UserTelepon { get; set; }

        public override string ToString()
        {
            return UserNama ?? string.Empty;
        }
    }

    public class EbookModel
    {
        public string EbookId { get; set; }
        public string EbookJudul { get; set; }
        public string EbookKategori { get; set; }
        public int EbookTotalEntri { get; set; }
        public string EbookPenulis { get; set; }
        public decimal EbookHarga { get; set; }
        public string EbookStatusAkses { get; set; }
        public string EbookDeskripsi { get; set; }
        public string EbookFile { get; set; }
        public bool EbookAktif { get; set; }
    }

    public class DiskonModel
    {
        public string DiskonId { get; set; }
        public string DiskonJenis { get; set; }
        public decimal DiskonNilai { get; set; }
        public decimal? DiskonMinimalTransaksi { get; set; }
        public DateTime? DiskonMulaiBerlaku { get; set; }
        public DateTime? DiskonMasaBerlaku { get; set; }
        public bool DiskonAktif { get; set; }
        public string DiskonCatatan { get; set; }
    }

    public class TransaksiSummaryModel
    {
        public string TransaksiId { get; set; }
        public string UserId { get; set; }
        public string PelangganId { get; set; }
        public string UserNama { get; set; }
        public string DiskonId { get; set; }
        public DateTime TransaksiTanggal { get; set; }
        public decimal TransaksiTotal { get; set; }
        public decimal TransaksiDiskon { get; set; }
        public decimal TransaksiGrandtotal { get; set; }
        public string TransaksiStatus { get; set; }
        public string JudulRingkas { get; set; }
        public string MetodePembayaran { get; set; }
        public string PembayaranId { get; set; }
        public string PembayaranStatus { get; set; }
        public string PembayaranReferensi { get; set; }
        public DateTime? PembayaranTanggal { get; set; }
    }

    public class TransaksiDetailItemModel
    {
        public string DetailId { get; set; }
        public string TransaksiId { get; set; }
        public string EbookId { get; set; }
        public string EbookJudul { get; set; }
        public string EbookPenulis { get; set; }
        public string EbookStatusAkses { get; set; }
        public decimal DetailHarga { get; set; }
        public int DetailQty { get; set; }
        public decimal DetailSubtotal { get; set; }
    }

    public class TransactionCartItem
    {
        public string EbookId { get; set; }
        public string EbookJudul { get; set; }
        public string EbookStatusAkses { get; set; }
        public decimal UnitPrice { get; set; }
        public decimal Subtotal => UnitPrice;
    }

    public class PembayaranModel
    {
        public string PembayaranId { get; set; }
        public string TransaksiId { get; set; }
        public string UserNama { get; set; }
        public string UserUsername { get; set; }
        public DateTime TransaksiTanggal { get; set; }
        public string JudulRingkas { get; set; }
        public string EbookId { get; set; }
        public string EbookStatusAkses { get; set; }
        public string PembayaranMetode { get; set; }
        public DateTime? PembayaranTanggal { get; set; }
        public decimal PembayaranJumlah { get; set; }
        public decimal TransaksiGrandtotal { get; set; }
        public string PembayaranStatus { get; set; }
        public string PembayaranReferensi { get; set; }
        public string TransaksiStatus { get; set; }
    }

    public static class DatabaseService
    {
        private static readonly CultureInfo IdCulture = new CultureInfo("id-ID");

        public static bool IsDesignMode()
        {
            return LicenseManager.UsageMode == LicenseUsageMode.Designtime;
        }

        public static SqlConnection GetConnection()
        {
            return new SqlConnection(koneksi.conn);
        }

        public static string FormatRupiah(decimal amount)
        {
            return "Rp " + amount.ToString("N0", IdCulture);
        }

        public static bool VerifyPassword(string inputPassword, string storedPassword)
        {
            if (string.IsNullOrEmpty(storedPassword)) return false;
            return string.Equals(inputPassword, storedPassword, StringComparison.Ordinal);
        }

        public static UserModel AuthenticateUser(string username, string password)
        {
            const string sql = @"
                SELECT TOP 1 [user_id], [user_nama], [user_username], [user_password], [user_role]
                FROM [users]
                WHERE [user_username] = @username";

            using (SqlConnection conn = GetConnection())
            using (SqlCommand cmd = new SqlCommand(sql, conn))
            {
                cmd.Parameters.Add("@username", SqlDbType.VarChar, 50).Value = username.Trim();
                conn.Open();
                using (SqlDataReader r = cmd.ExecuteReader())
                {
                    if (!r.Read()) return null;

                    string storedPassword = r["user_password"]?.ToString() ?? string.Empty;
                    if (!VerifyPassword(password, storedPassword)) return null;

                    return new UserModel
                    {
                        UserId = r["user_id"].ToString(),
                        UserNama = r["user_nama"].ToString(),
                        UserUsername = r["user_username"].ToString(),
                        UserRole = r["user_role"].ToString()
                    };
                }
            }
        }

        public static string GenerateNextId(SqlConnection conn, SqlTransaction tx, string tableName, string columnName, string prefix, int padLength)
        {
            string sql = $"SELECT TOP 1 [{columnName}] FROM [{tableName}] WHERE [{columnName}] LIKE @prefix ORDER BY LEN([{columnName}]) DESC, [{columnName}] DESC";
            using (SqlCommand cmd = new SqlCommand(sql, conn, tx))
            {
                cmd.Parameters.Add("@prefix", SqlDbType.VarChar, 30).Value = prefix + "%";
                object result = cmd.ExecuteScalar();
                int nextNum = 1;
                if (result != null && result != DBNull.Value)
                {
                    string lastId = result.ToString();
                    string numericPart = lastId.Substring(prefix.Length).TrimStart('-');
                    if (int.TryParse(numericPart, out int parsed))
                    {
                        nextNum = parsed + 1;
                    }
                }
                return prefix + nextNum.ToString().PadLeft(padLength, '0');
            }
        }

        public static decimal GetVerifiedQrisTotal()
        {
            const string sql = @"
        SELECT ISNULL(SUM(t.[transaksi_grandtotal]), 0)
        FROM [pembayaran] p
        INNER JOIN [transaksi] t ON t.[transaksi_id] = p.[transaksi_id]
        WHERE p.[pembayaran_metode] = 'QRIS'
          AND t.[transaksi_status] = 'Success'";
            using (SqlConnection conn = GetConnection())
            using (SqlCommand cmd = new SqlCommand(sql, conn))
            {
                conn.Open();
                return Convert.ToDecimal(cmd.ExecuteScalar());
            }
        }

        public static int GetActiveCustomerCount()
        {
            using (SqlConnection conn = GetConnection())
            using (SqlCommand cmd = new SqlCommand("SELECT COUNT(*) FROM dbo.pelanggan", conn))
            { conn.Open(); return Convert.ToInt32(cmd.ExecuteScalar()); }
        }

        #region E-Book CRUD

        public static List<EbookModel> GetEbooks(string keyword = "")
        {
            var list = new List<EbookModel>();
            const string sql = @"SELECT ebook_id, ebook_judul, ebook_kategori, ebook_total_entri, ebook_penulis,
                       ebook_harga, ebook_status_akses, ebook_deskripsi, ebook_file, ebook_aktif
                FROM dbo.ebook
                WHERE (@kw='' OR ebook_id LIKE @likeKw OR ebook_judul LIKE @likeKw OR ISNULL(ebook_penulis,'') LIKE @likeKw OR ebook_kategori LIKE @likeKw)
                ORDER BY ebook_id ASC";
            using (SqlConnection conn = GetConnection())
            using (SqlCommand cmd = new SqlCommand(sql, conn))
            {
                string kw=(keyword??string.Empty).Trim();
                cmd.Parameters.Add("@kw",SqlDbType.VarChar,150).Value=kw;
                cmd.Parameters.Add("@likeKw",SqlDbType.VarChar,160).Value="%"+kw+"%";
                conn.Open(); using(SqlDataReader r=cmd.ExecuteReader()) while(r.Read()) list.Add(new EbookModel {
                    EbookId=r["ebook_id"].ToString(), EbookJudul=r["ebook_judul"].ToString(), EbookKategori=r["ebook_kategori"].ToString(),
                    EbookTotalEntri=r["ebook_total_entri"]==DBNull.Value?0:Convert.ToInt32(r["ebook_total_entri"]),
                    EbookPenulis=r["ebook_penulis"]==DBNull.Value?string.Empty:r["ebook_penulis"].ToString(),
                    EbookHarga=Convert.ToDecimal(r["ebook_harga"]), EbookStatusAkses=r["ebook_status_akses"].ToString(),
                    EbookDeskripsi=r["ebook_deskripsi"]==DBNull.Value?string.Empty:r["ebook_deskripsi"].ToString(),
                    EbookFile=r["ebook_file"]==DBNull.Value?string.Empty:r["ebook_file"].ToString(), EbookAktif=Convert.ToBoolean(r["ebook_aktif"])
                });
            }
            return list;
        }

        public static void SaveEbook(EbookModel item, bool isNew)
        {
            using(SqlConnection conn=GetConnection()) { conn.Open();
                string id=string.IsNullOrWhiteSpace(item.EbookId)?GenerateNextId(conn,null,"ebook","ebook_id","EB-",3):item.EbookId.Trim();
                string sql=isNew ? @"INSERT INTO dbo.ebook(ebook_id,ebook_judul,ebook_kategori,ebook_total_entri,ebook_penulis,ebook_harga,ebook_status_akses,ebook_deskripsi,ebook_file,ebook_aktif)
                    VALUES(@id,@judul,@kategori,@entri,@penulis,@harga,@akses,@deskripsi,@file,@aktif)" :
                    @"UPDATE dbo.ebook SET ebook_judul=@judul,ebook_kategori=@kategori,ebook_total_entri=@entri,ebook_penulis=@penulis,ebook_harga=@harga,
                    ebook_status_akses=@akses,ebook_deskripsi=@deskripsi,ebook_file=@file,ebook_aktif=@aktif WHERE ebook_id=@id";
                using(SqlCommand cmd=new SqlCommand(sql,conn)) {
                    cmd.Parameters.Add("@id",SqlDbType.VarChar,10).Value=id;
                    cmd.Parameters.Add("@judul",SqlDbType.VarChar,150).Value=item.EbookJudul.Trim();
                    cmd.Parameters.Add("@kategori",SqlDbType.VarChar,100).Value=string.IsNullOrWhiteSpace(item.EbookKategori)?"Umum":item.EbookKategori.Trim();
                    cmd.Parameters.Add("@entri",SqlDbType.Int).Value=item.EbookTotalEntri;
                    cmd.Parameters.Add("@penulis",SqlDbType.VarChar,100).Value=(object)(item.EbookPenulis??string.Empty).Trim();
                    var h=cmd.Parameters.Add("@harga",SqlDbType.Decimal); h.Precision=18; h.Scale=2; h.Value=item.EbookHarga;
                    cmd.Parameters.Add("@akses",SqlDbType.VarChar,30).Value=item.EbookStatusAkses.Trim();
                    cmd.Parameters.Add("@deskripsi",SqlDbType.VarChar,-1).Value=string.IsNullOrWhiteSpace(item.EbookDeskripsi)?(object)DBNull.Value:item.EbookDeskripsi.Trim();
                    cmd.Parameters.Add("@file",SqlDbType.VarChar,255).Value=string.IsNullOrWhiteSpace(item.EbookFile)?(object)DBNull.Value:item.EbookFile.Trim();
                    cmd.Parameters.Add("@aktif",SqlDbType.Bit).Value=item.EbookAktif;
                    cmd.ExecuteNonQuery();
                }
            }
        }

        public static void DeleteEbook(string ebookId)
        {
            const string sql = "DELETE FROM [ebook] WHERE [ebook_id] = @id";
            using (SqlConnection conn = GetConnection())
            using (SqlCommand cmd = new SqlCommand(sql, conn))
            {
                cmd.Parameters.Add("@id", SqlDbType.VarChar, 10).Value = ebookId;
                conn.Open();
                cmd.ExecuteNonQuery();
            }
        }

        #endregion

        #region Diskon CRUD

        public static void DeactivateExpiredDiscounts()
        {
            const string sql = @"UPDATE dbo.diskon SET diskon_aktif = 0
                WHERE diskon_aktif = 1 AND diskon_masa_berlaku IS NOT NULL AND diskon_masa_berlaku < SYSDATETIME()";
            using (SqlConnection conn = GetConnection()) using (SqlCommand cmd = new SqlCommand(sql, conn))
            { conn.Open(); cmd.ExecuteNonQuery(); }
        }

        public static List<DiskonModel> GetDiskons(string keyword = "")
        {
            // Deaktivasi otomatis berlaku untuk Admin maupun Kasir saat daftar voucher dibaca.
            DeactivateExpiredDiscounts();
            var list=new List<DiskonModel>();
            const string sql=@"SELECT diskon_id,diskon_jenis,diskon_nilai,diskon_minimal_transaksi,diskon_mulai_berlaku,diskon_masa_berlaku,diskon_aktif,diskon_catatan
                FROM dbo.diskon WHERE (@kw='' OR diskon_id LIKE @likeKw OR diskon_jenis LIKE @likeKw OR ISNULL(diskon_catatan,'') LIKE @likeKw)
                ORDER BY diskon_masa_berlaku DESC";
            using(SqlConnection conn=GetConnection()) using(SqlCommand cmd=new SqlCommand(sql,conn)) {
                string kw=(keyword??string.Empty).Trim(); cmd.Parameters.Add("@kw",SqlDbType.VarChar,100).Value=kw; cmd.Parameters.Add("@likeKw",SqlDbType.VarChar,110).Value="%"+kw+"%";
                conn.Open(); using(SqlDataReader r=cmd.ExecuteReader()) while(r.Read()) list.Add(new DiskonModel {
                    DiskonId=r["diskon_id"].ToString(),DiskonJenis=r["diskon_jenis"].ToString(),DiskonNilai=Convert.ToDecimal(r["diskon_nilai"]),
                    DiskonMinimalTransaksi=r["diskon_minimal_transaksi"]==DBNull.Value?(decimal?)null:Convert.ToDecimal(r["diskon_minimal_transaksi"]),
                    DiskonMulaiBerlaku=r["diskon_mulai_berlaku"]==DBNull.Value?(DateTime?)null:Convert.ToDateTime(r["diskon_mulai_berlaku"]),
                    DiskonMasaBerlaku=r["diskon_masa_berlaku"]==DBNull.Value?(DateTime?)null:Convert.ToDateTime(r["diskon_masa_berlaku"]),
                    DiskonAktif=Convert.ToBoolean(r["diskon_aktif"]),DiskonCatatan=r["diskon_catatan"]==DBNull.Value?string.Empty:r["diskon_catatan"].ToString()
                });
            }
            return list;
        }

        public static void SaveDiskon(DiskonModel item, bool isNew)
        {
            const string insert=@"INSERT INTO dbo.diskon(diskon_id,diskon_jenis,diskon_nilai,diskon_minimal_transaksi,diskon_mulai_berlaku,diskon_masa_berlaku,diskon_aktif,diskon_catatan)
                VALUES(@id,@jenis,@nilai,@minimal,@mulai,@akhir,@aktif,@catatan)";
            const string update=@"UPDATE dbo.diskon SET diskon_jenis=@jenis,diskon_nilai=@nilai,diskon_minimal_transaksi=@minimal,diskon_mulai_berlaku=@mulai,
                diskon_masa_berlaku=@akhir,diskon_aktif=@aktif,diskon_catatan=@catatan WHERE diskon_id=@id";
            using(SqlConnection conn=GetConnection()) using(SqlCommand cmd=new SqlCommand(isNew?insert:update,conn)) {
                cmd.Parameters.Add("@id",SqlDbType.VarChar,15).Value=item.DiskonId.Trim(); cmd.Parameters.Add("@jenis",SqlDbType.VarChar,25).Value=item.DiskonJenis;
                var n=cmd.Parameters.Add("@nilai",SqlDbType.Decimal);n.Precision=18;n.Scale=2;n.Value=item.DiskonNilai;
                var m=cmd.Parameters.Add("@minimal",SqlDbType.Decimal);m.Precision=18;m.Scale=2;m.Value=item.DiskonMinimalTransaksi.HasValue?(object)item.DiskonMinimalTransaksi.Value:DBNull.Value;
                cmd.Parameters.Add("@mulai",SqlDbType.DateTime2).Value=item.DiskonMulaiBerlaku.HasValue?(object)item.DiskonMulaiBerlaku.Value:DBNull.Value;
                cmd.Parameters.Add("@akhir",SqlDbType.DateTime2).Value=item.DiskonMasaBerlaku.HasValue?(object)item.DiskonMasaBerlaku.Value:DBNull.Value;
                cmd.Parameters.Add("@aktif",SqlDbType.Bit).Value=item.DiskonAktif;
                cmd.Parameters.Add("@catatan",SqlDbType.VarChar,-1).Value=string.IsNullOrWhiteSpace(item.DiskonCatatan)?(object)DBNull.Value:item.DiskonCatatan.Trim();
                conn.Open();cmd.ExecuteNonQuery();
            }
        }

        public static void DeleteDiskon(string diskonId)
        {
            const string sql = "DELETE FROM [diskon] WHERE [diskon_id] = @id";
            using (SqlConnection conn = GetConnection())
            using (SqlCommand cmd = new SqlCommand(sql, conn))
            {
                cmd.Parameters.Add("@id", SqlDbType.VarChar, 15).Value = diskonId;
                conn.Open();
                cmd.ExecuteNonQuery();
            }
        }

        #endregion

        #region Transaksi & Pembayaran

        public static List<UserModel> GetMembers()
        {
            var list=new List<UserModel>();
            const string sql=@"SELECT pelanggan_id,pelanggan_nama,pelanggan_no_whatsapp FROM dbo.pelanggan ORDER BY pelanggan_nama";
            using(SqlConnection conn=GetConnection()) using(SqlCommand cmd=new SqlCommand(sql,conn)) { conn.Open(); using(SqlDataReader r=cmd.ExecuteReader()) while(r.Read()) list.Add(new UserModel {
                UserId=r["pelanggan_id"].ToString(),UserNama=r["pelanggan_nama"].ToString(),UserUsername=string.Empty,UserRole="Pelanggan",UserTelepon=r["pelanggan_no_whatsapp"]==DBNull.Value?string.Empty:r["pelanggan_no_whatsapp"].ToString()
            }); }
            return list;
        }

        private static string GetOrCreateCustomerId(SqlConnection conn, SqlTransaction tx, string customerName, string customerPhone)
        {
            string name=(customerName??string.Empty).Trim(); string phone=(customerPhone??string.Empty).Trim();
            if(name.Length>100) name=name.Substring(0,100); if(phone.Length>20) phone=phone.Substring(0,20);
            const string find=@"SELECT TOP 1 pelanggan_id FROM dbo.pelanggan WHERE pelanggan_nama=@nama AND ISNULL(pelanggan_no_whatsapp,'')=@phone";
            using(SqlCommand c=new SqlCommand(find,conn,tx)){c.Parameters.Add("@nama",SqlDbType.VarChar,100).Value=name;c.Parameters.Add("@phone",SqlDbType.VarChar,20).Value=phone;object v=c.ExecuteScalar();if(v!=null&&v!=DBNull.Value)return v.ToString();}
            // IDs lama memiliki format campuran (PLG-002 dan PLG-000001).
            // Ambil angka maksimum dari seluruh ID PLG agar tidak membuat duplicate key.
            int maxNo = 0;
            using (SqlCommand c = new SqlCommand(@"SELECT ISNULL(MAX(TRY_CONVERT(INT, SUBSTRING(pelanggan_id, 5, 20))),0)
                FROM dbo.pelanggan WITH (UPDLOCK, HOLDLOCK) WHERE pelanggan_id LIKE 'PLG-%'", conn, tx))
                maxNo = Convert.ToInt32(c.ExecuteScalar());
            string id = "PLG-" + (maxNo + 1).ToString("D6");
            using(SqlCommand c=new SqlCommand("INSERT INTO dbo.pelanggan(pelanggan_id,pelanggan_nama,pelanggan_no_whatsapp) VALUES(@id,@nama,@phone)",conn,tx)){
                c.Parameters.Add("@id",SqlDbType.VarChar,10).Value=id;c.Parameters.Add("@nama",SqlDbType.VarChar,100).Value=name;c.Parameters.Add("@phone",SqlDbType.VarChar,20).Value=string.IsNullOrWhiteSpace(phone)?(object)DBNull.Value:phone;c.ExecuteNonQuery();}
            return id;
        }

        public static string CreateTransaction(
            string customerName,
            string customerPhone,
            List<TransactionCartItem> items,
            string diskonId,
            decimal discountAmount,
            string paymentMethod = "QRIS")
        {
            if (string.IsNullOrWhiteSpace(customerName))
                throw new InvalidOperationException("Nama pelanggan wajib diisi.");
            if (items == null || items.Count == 0)
                throw new InvalidOperationException("Minimal harus ada 1 produk E-Book dalam transaksi.");

            decimal subtotal = items.Sum(item => item.Subtotal);

            if (discountAmount < 0m) discountAmount = 0m;
            if (discountAmount > subtotal) discountAmount = subtotal;
            decimal grandTotal = subtotal - discountAmount;

            using (SqlConnection conn = GetConnection())
            {
                conn.Open();
                using (SqlTransaction tx = conn.BeginTransaction())
                {
                    try
                    {
                        string customerId = GetOrCreateCustomerId(conn, tx, customerName, customerPhone);
                        if (string.IsNullOrWhiteSpace(UserSession.UserId)) throw new InvalidOperationException("Sesi kasir tidak ditemukan. Silakan login ulang.");

                        string yearPrefix = $"ORD-{DateTime.Now:yyyy}-";
                        string transaksiId = GenerateNextId(conn, tx, "transaksi", "transaksi_id", yearPrefix, 4);
                        string pembayaranId = GenerateNextId(conn, tx, "pembayaran", "pembayaran_id", "PAY-", 6);

                        const string insTrx = @"
                            INSERT INTO [transaksi] (
                                [transaksi_id], [user_id], [pelanggan_id], [diskon_id], [transaksi_tanggal],
                                [transaksi_total], [transaksi_diskon], [transaksi_grandtotal], [transaksi_status]
                            ) VALUES (
                                @trxId, @userId, @pelangganId, @diskonId, SYSDATETIME(),
                                @total, @diskon, @grandTotal, 'Pending'
                            )";

                        using (SqlCommand cmd = new SqlCommand(insTrx, conn, tx))
                        {
                            cmd.Parameters.Add("@trxId", SqlDbType.VarChar, 15).Value = transaksiId;
                            cmd.Parameters.Add("@userId", SqlDbType.VarChar, 10).Value = UserSession.UserId;
                            cmd.Parameters.Add("@pelangganId", SqlDbType.VarChar, 10).Value = customerId;
                            cmd.Parameters.Add("@diskonId", SqlDbType.VarChar, 15).Value =
                                string.IsNullOrWhiteSpace(diskonId) ? (object)DBNull.Value : diskonId.Trim();

                            SqlParameter pTot = cmd.Parameters.Add("@total", SqlDbType.Decimal);
                            pTot.Precision = 18; pTot.Scale = 2; pTot.Value = subtotal;

                            SqlParameter pDisc = cmd.Parameters.Add("@diskon", SqlDbType.Decimal);
                            pDisc.Precision = 18; pDisc.Scale = 2; pDisc.Value = discountAmount;

                            SqlParameter pGrand = cmd.Parameters.Add("@grandTotal", SqlDbType.Decimal);
                            pGrand.Precision = 18; pGrand.Scale = 2; pGrand.Value = grandTotal;

                            cmd.ExecuteNonQuery();
                        }

                        const string insDetail = @"INSERT INTO dbo.transaksi_detail(detail_id,transaksi_id,ebook_id,detail_harga,detail_subtotal)
                            VALUES(@detId,@trxId,@ebookId,@harga,@subtotal)";
                        foreach (var item in items)
                        {
                            // ERD tidak memiliki kolom qty: setiap E-Book dipilih satu kali
                            // dan direpresentasikan oleh satu baris transaksi_detail.
                            string detailId = GenerateNextId(conn, tx, "transaksi_detail", "detail_id", "DTL-", 6);
                            using (SqlCommand dCmd = new SqlCommand(insDetail, conn, tx))
                            {
                                dCmd.Parameters.Add("@detId", SqlDbType.VarChar, 15).Value = detailId;
                                dCmd.Parameters.Add("@trxId", SqlDbType.VarChar, 15).Value = transaksiId;
                                dCmd.Parameters.Add("@ebookId", SqlDbType.VarChar, 10).Value = item.EbookId.Trim();
                                SqlParameter ph = dCmd.Parameters.Add("@harga", SqlDbType.Decimal); ph.Precision=18; ph.Scale=2; ph.Value=item.UnitPrice;
                                SqlParameter ps = dCmd.Parameters.Add("@subtotal", SqlDbType.Decimal); ps.Precision=18; ps.Scale=2; ps.Value=item.UnitPrice;
                                dCmd.ExecuteNonQuery();
                            }
                        }

                        const string insPay = @"
                            INSERT INTO [pembayaran] (
                                [pembayaran_id], [transaksi_id], [pembayaran_metode],
                                [pembayaran_tanggal], [pembayaran_referensi]
                            ) VALUES (
                                @payId, @trxId, @metode,
                                NULL, @ref
                            )";

                        using (SqlCommand pCmd = new SqlCommand(insPay, conn, tx))
                        {
                            pCmd.Parameters.Add("@payId", SqlDbType.VarChar, 15).Value = pembayaranId;
                            pCmd.Parameters.Add("@trxId", SqlDbType.VarChar, 15).Value = transaksiId;
                            pCmd.Parameters.Add("@metode", SqlDbType.VarChar, 20).Value = "QRIS";

                            string refText = string.IsNullOrWhiteSpace(customerPhone)
                                ? null
                                : ("WA: " + customerPhone.Trim());
                            pCmd.Parameters.Add("@ref", SqlDbType.VarChar, 100).Value =
                                string.IsNullOrWhiteSpace(refText) ? (object)DBNull.Value : refText;

                            pCmd.ExecuteNonQuery();
                        }

                        tx.Commit();
                        return transaksiId;
                    }
                    catch
                    {
                        tx.Rollback();
                        throw;
                    }
                }
            }
        }

        public static List<TransaksiSummaryModel> GetTransactions(string keyword = "", string statusFilter = "Semua Status")
        {
            var list = new List<TransaksiSummaryModel>();
            const string sql = @"
                SELECT
                    t.[transaksi_id],
                    t.[user_id],
                    c.[pelanggan_nama] AS [user_nama],
                    t.[diskon_id],
                    t.[transaksi_tanggal],
                    t.[transaksi_total],
                    t.[transaksi_diskon],
                    t.[transaksi_grandtotal],
                    t.[transaksi_status],
                    ISNULL(STUFF((
                        SELECT CHAR(10) + e.[ebook_judul]
                        FROM [transaksi_detail] td
                        INNER JOIN [ebook] e ON e.[ebook_id] = td.[ebook_id]
                        WHERE td.[transaksi_id] = t.[transaksi_id]
                        ORDER BY td.[detail_id] ASC
                        FOR XML PATH(''), TYPE
                    ).value('.', 'nvarchar(max)'), 1, 1, ''), '-') AS [judul_ringkas],
                    p.[pembayaran_id],
                    ISNULL(p.[pembayaran_metode], '-') AS [pembayaran_metode],
                    CASE
                        WHEN t.[transaksi_status] = 'Success' THEN 'Verified'
                        WHEN t.[transaksi_status] = 'Canceled' THEN 'Rejected'
                        ELSE 'Pending'
                    END AS [pembayaran_status],
                    ISNULL(p.[pembayaran_referensi], '') AS [pembayaran_referensi],
                    p.[pembayaran_tanggal]
                FROM [transaksi] t
                INNER JOIN [pelanggan] c ON c.[pelanggan_id] = t.[pelanggan_id]
                OUTER APPLY (
                    SELECT TOP 1 *
                    FROM [pembayaran] p0
                    WHERE p0.[transaksi_id] = t.[transaksi_id]
                    ORDER BY p0.[pembayaran_tanggal] DESC, p0.[pembayaran_id] DESC
                ) p
                WHERE (@kw = '' OR t.[transaksi_id] LIKE @likeKw OR c.[pelanggan_nama] LIKE @likeKw OR EXISTS (
                    SELECT 1 FROM [transaksi_detail] tdX
                    INNER JOIN [ebook] eX ON eX.[ebook_id] = tdX.[ebook_id]
                    WHERE tdX.[transaksi_id] = t.[transaksi_id] AND eX.[ebook_judul] LIKE @likeKw
                ))
                AND (@st = 'Semua Status' OR t.[transaksi_status] = @st)
                ORDER BY t.[transaksi_tanggal] DESC";

            using (SqlConnection conn = GetConnection())
            using (SqlCommand cmd = new SqlCommand(sql, conn))
            {
                string kw = (keyword ?? string.Empty).Trim();
                cmd.Parameters.Add("@kw", SqlDbType.VarChar, 100).Value = kw;
                cmd.Parameters.Add("@likeKw", SqlDbType.VarChar, 110).Value = "%" + kw + "%";
                cmd.Parameters.Add("@st", SqlDbType.VarChar, 20).Value = string.IsNullOrWhiteSpace(statusFilter) ? "Semua Status" : statusFilter.Trim();

                conn.Open();
                using (SqlDataReader r = cmd.ExecuteReader())
                {
                    while (r.Read())
                    {
                        list.Add(new TransaksiSummaryModel
                        {
                            TransaksiId = r["transaksi_id"].ToString(),
                            UserId = r["user_id"].ToString(),
                            UserNama = r["user_nama"].ToString(),
                            DiskonId = r["diskon_id"] == DBNull.Value ? null : r["diskon_id"].ToString(),
                            TransaksiTanggal = Convert.ToDateTime(r["transaksi_tanggal"]),
                            TransaksiTotal = Convert.ToDecimal(r["transaksi_total"]),
                            TransaksiDiskon = Convert.ToDecimal(r["transaksi_diskon"]),
                            TransaksiGrandtotal = Convert.ToDecimal(r["transaksi_grandtotal"]),
                            TransaksiStatus = r["transaksi_status"].ToString(),
                            JudulRingkas = r["judul_ringkas"].ToString(),
                            PembayaranId = r["pembayaran_id"] == DBNull.Value ? null : r["pembayaran_id"].ToString(),
                            MetodePembayaran = r["pembayaran_metode"].ToString(),
                            PembayaranStatus = r["pembayaran_status"].ToString(),
                            PembayaranReferensi = r["pembayaran_referensi"].ToString(),
                            PembayaranTanggal = r["pembayaran_tanggal"] == DBNull.Value ? (DateTime?)null : Convert.ToDateTime(r["pembayaran_tanggal"])
                        });
                    }
                }
            }
            return list;
        }

        public static List<TransaksiDetailItemModel> GetTransactionDetails(string transaksiId)
        {
            var list = new List<TransaksiDetailItemModel>();
            const string sql = @"
                SELECT MIN(td.[detail_id]) AS [detail_id], td.[transaksi_id], td.[ebook_id],
                       e.[ebook_judul], e.[ebook_penulis], e.[ebook_status_akses],
                       td.[detail_harga], COUNT(*) AS [detail_qty], SUM(td.[detail_subtotal]) AS [detail_subtotal]
                FROM [transaksi_detail] td INNER JOIN [ebook] e ON e.[ebook_id] = td.[ebook_id]
                WHERE td.[transaksi_id] = @trxId
                GROUP BY td.[transaksi_id],td.[ebook_id],e.[ebook_judul],e.[ebook_penulis],e.[ebook_status_akses],td.[detail_harga]
                ORDER BY MIN(td.[detail_id]) ASC";

            using (SqlConnection conn = GetConnection())
            using (SqlCommand cmd = new SqlCommand(sql, conn))
            {
                cmd.Parameters.Add("@trxId", SqlDbType.VarChar, 15).Value = transaksiId;
                conn.Open();
                using (SqlDataReader r = cmd.ExecuteReader())
                {
                    while (r.Read())
                    {
                        list.Add(new TransaksiDetailItemModel
                        {
                            DetailId = r["detail_id"].ToString(),
                            TransaksiId = r["transaksi_id"].ToString(),
                            EbookId = r["ebook_id"].ToString(),
                            EbookJudul = r["ebook_judul"].ToString(),
                            EbookPenulis = r["ebook_penulis"].ToString(),
                            EbookStatusAkses = r["ebook_status_akses"].ToString(),
                            DetailHarga = Convert.ToDecimal(r["detail_harga"]),
                            DetailQty = Convert.ToInt32(r["detail_qty"]),
                            DetailSubtotal = Convert.ToDecimal(r["detail_subtotal"])
                        });
                    }
                }
            }
            return list;
        }

        public static void UpdateTransactionStatus(string transaksiId, string newStatus)
        {
            using (SqlConnection conn = GetConnection())
            {
                conn.Open();
                using (SqlTransaction tx = conn.BeginTransaction())
                {
                    try
                    {
                        const string getSql = "SELECT [transaksi_status] FROM [transaksi] WHERE [transaksi_id] = @id";
                        using (SqlCommand getCmd = new SqlCommand(getSql, conn, tx))
                        {
                            getCmd.Parameters.Add("@id", SqlDbType.VarChar, 15).Value = transaksiId;
                            using (SqlDataReader r = getCmd.ExecuteReader())
                            {
                                if (!r.Read())
                                    throw new InvalidOperationException("Transaksi tidak ditemukan.");
                                string oldStatus = r["transaksi_status"].ToString();
                            }
                        }

                        const string updTrx = "UPDATE [transaksi] SET [transaksi_status] = @status WHERE [transaksi_id] = @id";
                        using (SqlCommand updCmd = new SqlCommand(updTrx, conn, tx))
                        {
                            updCmd.Parameters.Add("@status", SqlDbType.VarChar, 20).Value = newStatus;
                            updCmd.Parameters.Add("@id", SqlDbType.VarChar, 15).Value = transaksiId;
                            updCmd.ExecuteNonQuery();
                        }

                        // Status pembayaran diturunkan dari transaksi_status.
                        // pembayaran hanya menyimpan metode, tanggal, dan referensi.
                        if (newStatus.Equals("Success", StringComparison.OrdinalIgnoreCase))
                        {
                            const string stampPayment = @"
                                UPDATE [pembayaran]
                                SET [pembayaran_tanggal] = ISNULL([pembayaran_tanggal], SYSDATETIME())
                                WHERE [transaksi_id] = @id";
                            using (SqlCommand payCmd = new SqlCommand(stampPayment, conn, tx))
                            {
                                payCmd.Parameters.Add("@id", SqlDbType.VarChar, 15).Value = transaksiId;
                                payCmd.ExecuteNonQuery();
                            }
                        }

                        tx.Commit();
                    }
                    catch
                    {
                        tx.Rollback();
                        throw;
                    }
                }
            }
        }

        public static List<PembayaranModel> GetPayments(string keyword = "", string methodFilter = "")
        {
            var list = new List<PembayaranModel>();
            const string sql = @"
                SELECT
                    p.[pembayaran_id],
                    p.[transaksi_id],
                    c.[pelanggan_nama] AS [user_nama],
                    CAST('' AS varchar(50)) AS [user_username],
                    t.[transaksi_tanggal],
                    t.[transaksi_grandtotal],
                    t.[transaksi_status],
                    p.[pembayaran_metode],
                    p.[pembayaran_tanggal],
                    CASE
                        WHEN t.[transaksi_status] = 'Success' THEN 'Verified'
                        WHEN t.[transaksi_status] = 'Canceled' THEN 'Rejected'
                        ELSE 'Pending'
                    END AS [pembayaran_status],
                    ISNULL(p.[pembayaran_referensi], '') AS [pembayaran_referensi],
                    ISNULL((
                        SELECT TOP 1 e.[ebook_id]
                        FROM [transaksi_detail] td
                        INNER JOIN [ebook] e ON e.[ebook_id] = td.[ebook_id]
                        WHERE td.[transaksi_id] = t.[transaksi_id]
                        ORDER BY td.[detail_id] ASC
                    ), '-') AS [ebook_id],
                    ISNULL((
                        SELECT TOP 1 e.[ebook_status_akses]
                        FROM [transaksi_detail] td
                        INNER JOIN [ebook] e ON e.[ebook_id] = td.[ebook_id]
                        WHERE td.[transaksi_id] = t.[transaksi_id]
                        ORDER BY td.[detail_id] ASC
                    ), '-') AS [ebook_status_akses],
                    ISNULL(STUFF((
                        SELECT CHAR(10) + e.[ebook_judul]
                        FROM [transaksi_detail] td
                        INNER JOIN [ebook] e ON e.[ebook_id] = td.[ebook_id]
                        WHERE td.[transaksi_id] = t.[transaksi_id]
                        ORDER BY td.[detail_id] ASC
                        FOR XML PATH(''), TYPE
                    ).value('.', 'nvarchar(max)'), 1, 1, ''), '-') AS [judul_ringkas]
                FROM [pembayaran] p
                INNER JOIN [transaksi] t ON t.[transaksi_id] = p.[transaksi_id]
                INNER JOIN [pelanggan] c ON c.[pelanggan_id] = t.[pelanggan_id]
                WHERE (@method = '' OR p.[pembayaran_metode] = @method)
                  AND (@kw = '' OR p.[pembayaran_id] LIKE @likeKw OR p.[transaksi_id] LIKE @likeKw OR c.[pelanggan_nama] LIKE @likeKw OR ISNULL(p.[pembayaran_referensi], '') LIKE @likeKw OR EXISTS (
                      SELECT 1 FROM [transaksi_detail] tdQ
                      INNER JOIN [ebook] eQ ON eQ.[ebook_id] = tdQ.[ebook_id]
                      WHERE tdQ.[transaksi_id] = t.[transaksi_id] AND eQ.[ebook_judul] LIKE @likeKw
                  ))
                ORDER BY ISNULL(p.[pembayaran_tanggal], t.[transaksi_tanggal]) DESC, p.[pembayaran_id] DESC";

            using (SqlConnection conn = GetConnection())
            using (SqlCommand cmd = new SqlCommand(sql, conn))
            {
                string kw = (keyword ?? string.Empty).Trim();
                string m = (methodFilter ?? string.Empty).Trim();
                cmd.Parameters.Add("@kw", SqlDbType.VarChar, 100).Value = kw;
                cmd.Parameters.Add("@likeKw", SqlDbType.VarChar, 110).Value = "%" + kw + "%";
                cmd.Parameters.Add("@method", SqlDbType.VarChar, 20).Value = m;

                conn.Open();
                using (SqlDataReader r = cmd.ExecuteReader())
                {
                    while (r.Read())
                    {
                        list.Add(new PembayaranModel
                        {
                            PembayaranId = r["pembayaran_id"].ToString(),
                            TransaksiId = r["transaksi_id"].ToString(),
                            UserNama = r["user_nama"].ToString(),
                            UserUsername = r["user_username"] == DBNull.Value ? string.Empty : r["user_username"].ToString(),
                            TransaksiTanggal = Convert.ToDateTime(r["transaksi_tanggal"]),
                            JudulRingkas = r["judul_ringkas"].ToString(),
                            EbookId = r["ebook_id"].ToString(),
                            EbookStatusAkses = r["ebook_status_akses"].ToString(),
                            PembayaranMetode = r["pembayaran_metode"].ToString(),
                            PembayaranTanggal = r["pembayaran_tanggal"] == DBNull.Value ? (DateTime?)null : Convert.ToDateTime(r["pembayaran_tanggal"]),
                            PembayaranJumlah = Convert.ToDecimal(r["transaksi_grandtotal"]),
                            TransaksiGrandtotal = Convert.ToDecimal(r["transaksi_grandtotal"]),
                            PembayaranStatus = r["pembayaran_status"].ToString(),
                            PembayaranReferensi = r["pembayaran_referensi"].ToString(),
                            TransaksiStatus = r["transaksi_status"].ToString()
                        });
                    }
                }
            }
            return list;
        }

        public static void VerifyPayment(string pembayaranId, string transaksiId, bool approve, string auditNoteOrReason)
        {
            using (SqlConnection conn = GetConnection())
            {
                conn.Open();
                using (SqlTransaction tx = conn.BeginTransaction())
                {
                    try
                    {
                        string newTrxStatus = approve ? "Success" : "Canceled";

                        // transaksi_status adalah satu-satunya sumber status verifikasi.
                        const string updTrx = @"
                            UPDATE [transaksi]
                            SET [transaksi_status] = @status
                            WHERE [transaksi_id] = @trxId
                              AND [transaksi_status] NOT IN ('Success', 'Canceled')";
                        using (SqlCommand tCmd = new SqlCommand(updTrx, conn, tx))
                        {
                            tCmd.Parameters.Add("@status", SqlDbType.VarChar, 20).Value = newTrxStatus;
                            tCmd.Parameters.Add("@trxId", SqlDbType.VarChar, 15).Value = transaksiId;
                            int affected = tCmd.ExecuteNonQuery();
                            if (affected != 1)
                                throw new InvalidOperationException("Transaksi ini sudah diproses atau tidak lagi menunggu verifikasi. Muat ulang daftar pembayaran.");
                        }

                        // pembayaran_tanggal dan pembayaran_referensi tetap merupakan metadata pembayaran.
                        const string updPay = @"
                            UPDATE [pembayaran]
                            SET [pembayaran_tanggal] = ISNULL([pembayaran_tanggal], SYSDATETIME()),
                                [pembayaran_referensi] = CASE
                                    WHEN @note <> '' AND ISNULL([pembayaran_referensi], '') = '' THEN LEFT(@note, 100)
                                    ELSE [pembayaran_referensi]
                                END
                            WHERE [pembayaran_id] = @payId
                              AND [transaksi_id] = @trxId";
                        using (SqlCommand pCmd = new SqlCommand(updPay, conn, tx))
                        {
                            pCmd.Parameters.Add("@note", SqlDbType.VarChar, 100).Value = (auditNoteOrReason ?? string.Empty).Trim();
                            pCmd.Parameters.Add("@payId", SqlDbType.VarChar, 15).Value = pembayaranId;
                            pCmd.Parameters.Add("@trxId", SqlDbType.VarChar, 15).Value = transaksiId;
                            pCmd.ExecuteNonQuery();
                        }

                        tx.Commit();
                    }
                    catch
                    {
                        tx.Rollback();
                        throw;
                    }
                }
            }
        }

        #endregion
    }
}
