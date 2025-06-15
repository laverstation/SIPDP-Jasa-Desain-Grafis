<!-- Footer -->
<footer class="sticky-footer">
  <div class="container my-auto">
    <div class="copyright text-center my-auto">
      <span>Copyright &copy; PT. Ekspor Antero Nusantara | Sistem Informasi Pengelolaan Data Pemesanan Jasa Desain
      </span>
    </div>
  </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->

<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/sb-admin-2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/demo/datatables-demo.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
  $(document).ready(function() {
    // Initialize DataTables
    var dataTableJob = $('#dataTableJob').DataTable({
      // Your DataTable options here
    });

    // Attach Select2 plugin to the dropdowns for enhanced features
    $('#filter-jabatan').select2();
    $('#filter-status').select2();

    // Add event listeners to the dropdowns
    $('#filter-jabatan').on('change', function() {
      var selectedCategory = $(this).val();
      var selectedStatus = $('#filter-status').val();
      applyFilter(selectedCategory, selectedStatus);
    });

    $('#filter-status').on('change', function() {
      var selectedStatus = $(this).val();
      var selectedCategory = $('#filter-jabatan').val();
      applyFilter(selectedCategory, selectedStatus);
    });

    function applyFilter(category, status) {
      // Clear the current filters
      dataTableJob.search('').columns().search('').draw();

      // Apply the new filters based on the selected values
      if (category) {
        dataTableJob.column(1).search(category).draw();
      }
      if (status) {
        dataTableJob.column(9).search(status).draw();
      }
    }
  });
</script>



<?php
if (isset($larisIllustrasiCount)) {
?>

  <script type="text/javascript">
    // Pie Chart Example
    var ctx = document.getElementById("myPieChart");
    var myPieChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ["Animasi", "Illustrasi", "3D Rendering"],
        datasets: [{
          data: [<?php echo $larisAnimasiCount; ?>, <?php echo $larisIllustrasiCount; ?>, <?php echo $laris3DCount; ?>],
          backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#dddfeb'],
          hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#dddfeb'],
          hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          caretPadding: 10,
        },
        legend: {
          display: false
        },
        cutoutPercentage: 80,
      },
    });
  </script>

  <script type="text/javascript">
    // Bar Chart Example
    var ctx = document.getElementById("myBarChart");
    var myBarChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "November", "Desember"], // Ganti label bulan sesuai kebutuhan
        datasets: [
          <?php if (isset($queryIllustrasi)) {
          ?> {
              label: "Animasi",
              backgroundColor: 'rgb(23, 125, 255)',
              borderColor: 'rgb(23, 125, 255)',
              data: [<?php
                      for ($x = 1; $x <= 12; $x++) {

                        $found = false;

                        foreach ($queryAnimasi as $item) {
                          if ($item->bulan == $x) {
                            echo $item->total_pendapatan_animasi . ',';
                            $found = true;
                            break;
                          }
                        }

                        if (!$found) {
                          echo "0 ,";
                        }
                      }

                      ?>], // Ganti data pendapatan animasi sesuai bulan (dalam contoh ini menggunakan data acak)
            },
          <?php }
          if (isset($queryIllustrasi)) { ?> {
              label: "Illustrasi",
              backgroundColor: 'rgb(255, 99, 132)',
              borderColor: 'rgb(255, 99, 132)',
              data: [<?php
                      for ($x = 1; $x <= 12; $x++) {

                        $found = false;

                        foreach ($queryIllustrasi as $item) {
                          if ($item->bulan == $x) {
                            echo $item->total_pendapatan_illustrasi . ',';
                            $found = true;
                            break;
                          }
                        }

                        if (!$found) {
                          echo "0 ,";
                        }
                      }

                      ?>], // Ganti data pendapatan illustrasi sesuai bulan (dalam contoh ini menggunakan data acak)
            },
          <?php }
          if (isset($query3D)) { ?> {
              label: "3D Rendering",
              backgroundColor: 'rgb(255, 212, 99)',
              borderColor: 'rgb(255, 212, 99)',
              data: [<?php
                      for ($x = 1; $x <= 12; $x++) {

                        $found = false;

                        foreach ($query3D as $item) {
                          if ($item->bulan == $x) {
                            echo $item->total_pendapatan_3d . ',';
                            $found = true;
                            break;
                          }
                        }

                        if (!$found) {
                          echo "0 ,";
                        }
                      }

                      ?>], // Ganti data pendapatan illustrasi sesuai bulan (dalam contoh ini menggunakan data acak)
            },
          <?php } ?>
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        },
      }
    });
  </script>

<?php

}
?>


</body>

</html>