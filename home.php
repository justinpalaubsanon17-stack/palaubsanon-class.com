<?php



            $mydb->setQuery("SELECT  count(`AlumniID`) as TotalAlumni FROM `alumni_details`");
            $inst = $mydb->loadSingleResult();
            ?>

<style>
  /* ---- Dashboard entrance animation ---- */
  @keyframes dashCardIn {
    from {
      opacity: 0;
      transform: translateY(28px) scale(0.96);
    }
    to {
      opacity: 1;
      transform: translateY(0) scale(1);
    }
  }

  @keyframes iconFloat {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    50%      { transform: translateY(-6px) rotate(4deg); }
  }

  @keyframes shimmer {
    0%   { background-position: -300px 0; }
    100% { background-position: 300px 0; }
  }

  .dash-animate {
    opacity: 0;
    animation: dashCardIn 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards;
  }

  .dash-animate:nth-child(1) { animation-delay: 0.05s; }
  .dash-animate:nth-child(2) { animation-delay: 0.15s; }
  .dash-animate:nth-child(3) { animation-delay: 0.25s; }
  .dash-animate:nth-child(4) { animation-delay: 0.35s; }

  /* ---- Card base styling ---- */
  .small-box {
    position: relative;
    overflow: hidden;
    border-radius: 14px;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .small-box::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.16) 0%, rgba(255,255,255,0) 60%);
    pointer-events: none;
  }

  .small-box:hover {
    transform: translateY(-8px);
    box-shadow: 0 16px 30px rgba(0, 0, 0, 0.22);
  }

  /* Gradient backgrounds per color, overriding flat AdminLTE colors */
  .small-box.bg-info    { background: linear-gradient(135deg, #17a2e6 0%, #0d6fa8 100%) !important; }
  .small-box.bg-success { background: linear-gradient(135deg, #2fd08a 0%, #12925c 100%) !important; }
  .small-box.bg-warning { background: linear-gradient(135deg, #ffc65c 0%, #e0932c 100%) !important; }
  .small-box.bg-danger  { background: linear-gradient(135deg, #ff6f6f 0%, #d13a3a 100%) !important; }

  .small-box .inner h3 {
    font-weight: 700;
    letter-spacing: 0.5px;
    text-shadow: 0 2px 6px rgba(0,0,0,0.15);
  }

  /* ---- Icon styling ---- */
  .small-box .icon {
    transition: transform 0.3s ease, opacity 0.3s ease;
    opacity: 0.35;
  }

  .small-box:hover .icon {
    opacity: 0.55;
    animation: iconFloat 1.6s ease-in-out infinite;
  }

  /* ---- Footer link shimmer + arrow nudge ---- */
  .small-box-footer {
    position: relative;
    transition: background 0.25s ease, letter-spacing 0.25s ease;
  }

  .small-box-footer:hover {
    background: rgba(0, 0, 0, 0.12) !important;
    letter-spacing: 0.5px;
  }

  .small-box-footer i {
    display: inline-block;
    transition: transform 0.25s ease;
  }

  .small-box-footer:hover i {
    transform: translateX(4px);
  }

  /* Subtle shimmer sweep across the card once on load */
  .small-box::after {
    content: "";
    position: absolute;
    top: 0;
    left: -150px;
    width: 150px;
    height: 100%;
    background: linear-gradient(120deg, transparent, rgba(255,255,255,0.35), transparent);
    animation: shimmer 2.2s ease-in-out 0.6s 1;
    pointer-events: none;
  }
</style>

<section class="content">

      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          </div>
      </div><!-- /.container-fluid -->





        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6 dash-animate">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><span class="counter" data-target="<?php echo (isset($inst->TotalAlumni)) ? (int)$inst->TotalAlumni : 0; ?>">0</span></h3>

                <p>Alumni Count</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6 dash-animate">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><span class="counter" data-target="53">0</span><sup style="font-size: 20px">%</sup></h3>

                <p>Bounce Rate</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6 dash-animate">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><span class="counter" data-target="44">0</span></h3>

                <p>User Registrations</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6 dash-animate">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><span class="counter" data-target="65">0</span></h3>

                <p>Unique Visitors</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->


    </section>

<script>
  // Count-up animation for the stat numbers
  document.addEventListener('DOMContentLoaded', function () {
    var counters = document.querySelectorAll('.counter');

    counters.forEach(function (counter) {
      var target = parseInt(counter.getAttribute('data-target'), 10) || 0;
      var duration = 1000; // ms
      var startTime = null;

      function step(timestamp) {
        if (!startTime) startTime = timestamp;
        var progress = Math.min((timestamp - startTime) / duration, 1);
        // ease-out for a nicer deceleration near the end
        var eased = 1 - Math.pow(1 - progress, 3);
        var value = Math.floor(eased * target);
        counter.textContent = value;
        if (progress < 1) {
          window.requestAnimationFrame(step);
        } else {
          counter.textContent = target;
        }
      }

      window.requestAnimationFrame(step);
    });
  });
</script>