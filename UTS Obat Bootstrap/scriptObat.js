/* ==================== DATA OBAT ==================== */
const dataObat = [
  { nama: "Paracetamol", jenis: "sakit kepala", dosis: "ringan", keterangan: "Pereda nyeri dan penurun demam.", penggunaan: "Diminum 3x sehari setelah makan." },
  { nama: "OBH Combi", jenis: "batuk", dosis: "sedang", keterangan: "Meredakan batuk berdahak dan tenggorokan gatal.", penggunaan: "Diminum 3x sehari 1 sendok takar." },
  { nama: "Panadol Flu", jenis: "flu", dosis: "sedang", keterangan: "Meredakan gejala flu dan sakit kepala.", penggunaan: "1 tablet setiap 8 jam." },
  { nama: "Procold", jenis: "flu", dosis: "ringan", keterangan: "Mengatasi flu ringan dan hidung tersumbat.", penggunaan: "1 kapsul setiap 12 jam." },
  { nama: "Decolsin", jenis: "flu", dosis: "tinggi", keterangan: "Untuk gejala flu berat dengan demam tinggi.", penggunaan: "1 kapsul setiap 8 jam." },
  { nama: "Siladex", jenis: "batuk", dosis: "ringan", keterangan: "Meredakan batuk kering tanpa alkohol.", penggunaan: "Diminum 3x sehari 1 sendok takar." },
  { nama: "Bodrex Migra", jenis: "sakit kepala", dosis: "tinggi", keterangan: "Mengatasi sakit kepala hebat dan migrain.", penggunaan: "1 tablet saat sakit kepala kambuh." }
];

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
    noResult.classList.remove("d-none");
    return;
  }

  noResult.classList.add("d-none");

  filteredData
    .sort((a, b) => a.nama.localeCompare(b.nama))
    .forEach(item => {
      const row = document.createElement("tr");
      row.style.cursor = "pointer";
      
      const namaCol = document.createElement("td");
      namaCol.innerHTML = `<strong>${item.nama}</strong>`;
      
      const keteranganCol = document.createElement("td");
      keteranganCol.textContent = item.keterangan;
      
      const dosisCol = document.createElement("td");
      dosisCol.innerHTML = `<span class="badge bg-info">${item.dosis.charAt(0).toUpperCase() + item.dosis.slice(1)}</span>`;

      row.appendChild(namaCol);
      row.appendChild(keteranganCol);
      row.appendChild(dosisCol);

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

  const filtered = dataObat.filter(o => {
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

renderList(dataObat);

/* ==================== TAMBAH OBAT BARU ==================== */
document.getElementById("formTambahObat").addEventListener("submit", async (e) => {
  e.preventDefault();

  const newObat = {
    nama: document.getElementById("namaInput").value,
    jenis: document.getElementById("jenisInput").value.toLowerCase(),
    dosis: document.getElementById("dosisInput").value.toLowerCase(),
    keterangan: document.getElementById("keteranganInput").value,
    penggunaan: document.getElementById("penggunaanInput").value
  };

  try {
    const response = await fetch("tambahObat.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(newObat)
    });

    const result = await response.json();
    if (result.success) {
      alert("Obat berhasil ditambahkan!");
      dataObat.push(newObat);
      renderList(dataObat);
      e.target.reset();
    } else {
      alert("Gagal menambah obat: " + result.message);
    }
  } catch (err) {
    console.error("Error:", err);
    alert("Terjadi kesalahan saat menambah obat.");
  }
});