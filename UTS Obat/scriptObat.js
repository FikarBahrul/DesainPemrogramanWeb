/* ==================== DATA OBAT ==================== */
const dataObat = [
  { nama: "Paracetamol", jenis: "sakit kepala", dosis: "ringan", keterangan: "Pereda nyeri dan penurun demam.", penggunaan: "Diminum 3x sehari setelah makan." },
  { nama: "OBH Combi", jenis: "batuk", dosis: "sedang", keterangan: "Meredakan batuk berdahak dan tenggorokan gatal.", penggunaan: "Diminum 3x sehari 1 sendok takar." },
  { nama: "Panadol Flu", jenis: "flu", dosis: "sedang", keterangan: "Meredakan gejala flu dan sakit kepala.", penggunaan: "1 tablet setiap 8 jam." },
  { nama: "Procold", jenis: "flu", dosis: "ringan", keterangan: "Mengatasi flu ringan dan hidung tersumbat.", penggunaan: "1 kapsul setiap 12 jam." },
  { nama: "Decolsin", jenis: "flu", dosis: "tinggi", keterangan: "Untuk gejala flu berat dengan demam tinggi.", penggunaan: "1 kapsul setiap 8 jam." },
  { nama: "Siladex", jenis: "batuk", dosis: "ringan", keterangan: "Meredakan batuk kering tanpa alkohol.", penggunaan: "Diminum 3x sehari 1 sendok takar." },
  { nama: "Bodrex Migra", jenis: "sakit kepala", dosis: "tinggi", keterangan: "Mengatasi sakit kepala hebat dan migrain.", penggunaan: "1 tablet saat sakit kepala kambuh." }
]; //Array dataObat akan masuk ke filter obat dan renderlist->indexObat.html melalui id

/* ==================== AMBIL ELEMEN HTML ==================== */
const searchInput = document.getElementById("searchInput");
const searchBtn = document.getElementById("searchBtn");
const jenisSelect = document.getElementById("jenis");
const dosisSelect = document.getElementById("dosis");
const obatList = document.getElementById("obatList");
const noResult = document.getElementById("noResult");

/* ==================== FUNGSI TAMPILKAN DAFTAR ==================== */
function renderList(filteredData) {
  obatList.innerHTML = "";

  if (filteredData.length === 0) {
    noResult.style.display = "block";
    return;
  }

  noResult.style.display = "none";

  filteredData
    .sort((a, b) => a.nama.localeCompare(b.nama))
    .forEach(item => {
      //container untuk satu baris obat
      const row = document.createElement("div");
      row.classList.add("obat-row");

      //3 kolom terpisah sebagai nama, keterangan, dan dosis
      const namaCol = document.createElement("div");
      namaCol.classList.add("grid-item", "nama-obat");
      namaCol.textContent = item.nama;

      const keteranganCol = document.createElement("div");
      keteranganCol.classList.add("grid-item");
      keteranganCol.textContent = item.keterangan;

      const dosisCol = document.createElement("div");
      dosisCol.classList.add("grid-item", "dosis-obat");
      dosisCol.textContent = item.dosis.charAt(0).toUpperCase() + item.dosis.slice(1);

      row.appendChild(namaCol);
      row.appendChild(keteranganCol);
      row.appendChild(dosisCol);

      // href ke detail
      row.addEventListener("click", () => {
        localStorage.setItem("detailObat", JSON.stringify(item));
        window.location.href = "detailObat.html";
      });

      obatList.appendChild(row);
    });
}

/* ==================== FUNGSI FILTER OBAT ==================== */
function filterObat() {
  const keyword = searchInput.value.toLowerCase();
  const jenis = jenisSelect.value;
  const dosis = dosisSelect.value;

  const filtered = dataObat.filter(o => { //memanggil Array dataObat sebagai filter berdasarkan input user (EVALUASI SETELAH UTS)
    const matchNama = o.nama.toLowerCase().includes(keyword);
    const matchJenis = jenis === "semua" || o.jenis === jenis;
    const matchDosis = dosis === "semua" || o.dosis === dosis;
    return matchNama && matchJenis && matchDosis;
  });

  renderList(filtered);
}

/* ==================== EVENT LISTENER ==================== */
searchBtn.addEventListener("click", filterObat);
searchInput.addEventListener("keyup", e => { if (e.key === "Enter") filterObat(); });
jenisSelect.addEventListener("change", filterObat);
dosisSelect.addEventListener("change", filterObat);

renderList(dataObat); //memuat seluruh dataObat dari memanggil Array dataObat -> Masuk ke indexObat.html (EVALUASI SETELAH UTS)

/* ==================== TAMBAH OBAT BARU ((nanti masuk ke database)EVALUASI SETELAH UTS) ==================== */
document.getElementById("formTambahObat").addEventListener("submit", async (e) => { //async: Menandai fungsi ini asynchronous (bisa pakai await) e: object
  e.preventDefault(); //Mencegah form melakukan reload halaman

  const newObat = {
    nama: document.getElementById("namaInput").value, //value mengambil nilai input dari field
    jenis: document.getElementById("jenisInput").value.toLowerCase(),//toLowercase mengubah huruf menjadi kecil
    dosis: document.getElementById("dosisInput").value.toLowerCase(),
    keterangan: document.getElementById("keteranganInput").value,
    penggunaan: document.getElementById("penggunaanInput").value
  };

  try {
    // Kirim ke server (PHP)
    const response = await fetch("tambahObat.php", { //fetch digunakan untuk kirim http request/AJAX. await menunggu request AJAX selesai.
      method: "POST",
      headers: { "Content-Type": "application/json" }, //data yang dikirim berupa JSON
      body: JSON.stringify(newObat) //data yang dikirim object tadi diubah menjadi StringJSON
    });

    const result = await response.json();// .jSON adalah parse respon dari server jadi object Javascript
    if (result.success) {
      alert("Obat berhasil ditambahkan!"); //pop-up web
      dataObat.push(newObat); //menambahkan obat baru ke array dataObat
      renderList(dataObat); //refresh tampilan setelah obat baru ditambahkan oleh .push
      e.target.reset();//Kosongkan semua input form
    } else {
      alert("Gagal menambah obat: " + result.message);
    }
  } catch (err) {
    console.error("Error:", err);
    alert("Terjadi kesalahan saat menambah obat.");
  }
});