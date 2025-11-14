/* ==================== AMBIL DATA DARI LOCALSTORAGE ==================== */
const obatData = JSON.parse(localStorage.getItem("detailObat"));

/* ==================== MAPPING NAMA FILE GAMBAR ==================== */
const gambarMapping = {
  "Paracetamol": "paracetamol.jpg",
  "OBH Combi": "obh-combi.jpg",
  "Panadol Flu": "panadol-flu.jpg",
  "Procold": "procold.jpg",
  "Decolsin": "decolsin.jpg",
  "Siladex": "siladex.jpg",
  "Bodrex Migra": "bodrex-migra.jpg"
};

/* ==================== TAMPILKAN DETAIL OBAT ==================== */
if (obatData) {
  const namaObat = document.getElementById("namaObat");
  const gambarObat = document.getElementById("gambarObat");
  const keteranganObat = document.getElementById("keteranganObat");
  const dosisObat = document.getElementById("dosisObat");
  const penggunaanObat = document.getElementById("penggunaanObat");

  namaObat.textContent = obatData.nama;
  keteranganObat.textContent = obatData.keterangan;
  dosisObat.textContent = `Dosis: ${obatData.dosis.charAt(0).toUpperCase() + obatData.dosis.slice(1)}`;
  penggunaanObat.textContent = obatData.penggunaan;

  const namaFileGambar = gambarMapping[obatData.nama] || "default.jpg";
  gambarObat.src = `gambarObat/${namaFileGambar}`;
  gambarObat.alt = `Gambar ${obatData.nama}`;

  gambarObat.onerror = function() {
    this.src = "gambarObat/default.jpg";
    this.alt = "Gambar tidak tersedia";
  };

} else {
  alert("Data obat tidak ditemukan!");
  window.location.href = "indexObat.html";
}