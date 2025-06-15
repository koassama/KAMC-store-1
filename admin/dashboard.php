<?php
  session_start();

  if (isset($_SESSION['admin']))
  {
    $pageTitle = 'لوحة التحكم - اخر الاحصائيات';
    include 'init.php';
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ? LIMIT 1 ");
    $stmt->execute(array($_SESSION['id']));
    $admin = $stmt->fetch();

    ?>
      <!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>لوحة التحكم المحسنة</title>
  
  <!-- Bootstrap & Font Awesome -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Almarai', sans-serif;
      background-color: #f1f4f8;
      direction: rtl;
    }

    .dashboard {
      margin-right:220px;
      margin-top:-80px     !important;
      padding: 30px;
      background-color: #f1f4f8;
    }

    .cnt-spc {
      padding: 20px 15px;
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(2, 400px);
      grid-template-rows: repeat(2, 400px);
      gap: 20px;
      margin-top: 20px;
      justify-content: center;
    }

    .stat-card {
      background: white;
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
      transition: all 0.4s ease;
      cursor: pointer;
      border: 1px solid rgba(255, 255, 255, 0.2);
      position: relative;
      overflow: hidden;
      width: 400px;
      height: 400px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .stat-card::before {
      content: '';
      position: absolute;
      top: 0;
      right: 0;
      width: 100%;
      height: 4px;
      background: linear-gradient(90deg, var(--card-color), var(--card-color-light));
      transition: height 0.3s ease;
    }

    .stat-card:hover::before {
      height: 8px;
    }

    .stat-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 25px rgba(0, 0, 0, 0.12);
    }

    .stat-card.incoming {
      --card-color: #3b82f6;
      --card-color-light: #60a5fa;
    }

    .stat-card.outgoing {
      --card-color: #10b981;
      --card-color-light: #34d399;
    }

    .stat-card.consumables {
      --card-color: #f59e0b;
      --card-color-light: #fbbf24;
    }

    .stat-card.inventory {
      --card-color: #8b5cf6;
      --card-color-light: #a78bfa;
    }

    .card-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 25px;
    }

    .card-icon {
      width: 80px;
      height: 80px;
      border-radius: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, var(--card-color), var(--card-color-light));
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
    }

    .card-icon svg {
      width: 40px;
      height: 40px;
      filter: brightness(0) invert(1);
    }

    .stat-card:hover .card-icon {
      transform: scale(1.05);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }

    .card-trend {
      display: flex;
      align-items: center;
      font-size: 16px;
      color: #10b981;
      font-weight: 600;
    }

    .card-trend i {
      margin-left: 5px;
    }

    .card-body {
      text-align: center;
    }

    .card-number {
      font-size: 64px;
      font-weight: 700;
      color: var(--card-color);
      margin: 20px 0;
      line-height: 1;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
    }

    .stat-card:hover .card-number {
      transform: scale(1.05);
    }

    .card-title {
      font-size: 24px;
      font-weight: 600;
      color: #1f2937;
      margin: 0;
      line-height: 1.3;
    }

    .card-subtitle {
      font-size: 16px;
      color: #6b7280;
      margin-top: 8px;
    }

    .card-progress {
      margin-top: 25px;
      height: 8px;
      background-color: #f3f4f6;
      border-radius: 12px;
      overflow: hidden;
      position: relative;
    }

    .progress-fill {
      height: 100%;
      background: linear-gradient(90deg, var(--card-color), var(--card-color-light));
      border-radius: 12px;
      transition: width 1s ease;
      position: relative;
    }

    .progress-fill::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
      animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
      0% { transform: translateX(-100%); }
      100% { transform: translateX(100%); }
    }

    .stat-card:hover .progress-fill {
      box-shadow: 0 0 10px var(--card-color);
    }

    /* Pulse animation for numbers */
    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.02); }
      100% { transform: scale(1); }
    }

    .card-number.animate {
      animation: pulse 0.6s ease-in-out;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .stats-grid {
        grid-template-columns: 1fr;
        grid-template-rows: repeat(4, 300px);
        gap: 20px;
      }
      
      .stat-card {
        width: 100%;
        height: 300px;
        padding: 25px;
      }
      
      .card-number {
        font-size: 48px;
      }
      
      .card-icon {
        width: 60px;
        height: 60px;
      }
      
      .card-icon svg {
        width: 30px;
        height: 30px;
      }
      
      .card-title {
        font-size: 20px;
      }
      
      .card-subtitle {
        font-size: 14px;
      }
      
      .card-trend {
        font-size: 14px;
      }
    }

    @media (max-width: 576px) {
      .dashboard {
        padding: 20px 15px;
      }
      
      .stats-grid {
        grid-template-columns: 1fr;
        grid-template-rows: repeat(4, 250px);
        gap: 20px;
      }
      
      .stat-card {
        width: 100%;
        height: 250px;
        padding: 20px;
      }
      
      .card-number {
        font-size: 40px;
      }
      
      .card-icon {
        width: 50px;
        height: 50px;
      }
      
      .card-icon svg {
        width: 25px;
        height: 25px;
      }
      
      .card-title {
        font-size: 18px;
      }
      
      .card-subtitle {
        font-size: 12px;
      }
      
      .card-trend {
        font-size: 12px;
      }
    }
  </style>
</head>
<body>

<div class="dashboard lf-pd" id="dashboard">
  <div class="container cnt-spc">
    <div class="stats-grid">

      <!-- الأجهزة الواردة -->
      <div class="stat-card incoming" onclick="animateCard(this)">
        <div class="card-header">
          <div class="card-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M14 12L10 8V11H2V13H10V16M20 18V6C20 5.46957 19.7893 4.96086 19.4142 4.58579C19.0391 4.21071 18.5304 4 18 4H6C5.46957 4 4.96086 4.21071 4.58579 4.58579C4.21071 4.96086 4 5.46957 4 6V9H6V6H18V18H6V15H4V18C4 18.5304 4.21071 19.0391 4.58579 19.4142C4.96086 19.7893 5.46957 20 6 20H18C18.5304 20 19.0391 19.7893 19.4142 19.4142C19.7893 19.0391 20 18.5304 20 18Z" fill="black"/>
            </svg>
          </div>
          <div class="card-trend">
            <i class="fas fa-arrow-up"></i>
            +12%
          </div>
        </div>
        
        <div class="card-body">
          <?php
            $stmt = $conn->prepare("SELECT * FROM piece ");
            $stmt ->execute();
            $tt = $stmt->rowCount();
           ?>
          <div class="card-number"><?php echo $tt ?></div>
          <h3 class="card-title">الأجهزة الواردة</h3>
          <p class="card-subtitle">إجمالي الأجهزة المستلمة</p>
          <div class="card-progress">
            <div class="progress-fill" style="width: 85%;"></div>
          </div>
        </div>
      </div>

      <!-- الأجهزة الصادرة -->
      <div class="stat-card outgoing" onclick="animateCard(this)">
        <div class="card-header">
          <div class="card-icon">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M8.505 1.00001C8.927 0.997008 9.349 1.17001 9.671 1.51601L11.621 3.56601C11.834 3.79401 11.834 4.16601 11.621 4.39401C11.5723 4.44786 11.5128 4.4909 11.4464 4.52035C11.38 4.54981 11.3081 4.56502 11.2355 4.56502C11.1629 4.56502 11.091 4.54981 11.0246 4.52035C10.9582 4.4909 10.8987 4.44786 10.85 4.39401L9 2.45101V10.444C9 10.751 8.776 11 8.5 11C8.224 11 8 10.751 8 10.444V2.48401L6.18 4.39401C6.13126 4.44769 6.07183 4.49059 6.00553 4.51995C5.93922 4.54931 5.86751 4.56447 5.795 4.56447C5.72249 4.56447 5.65078 4.54931 5.58448 4.51995C5.51817 4.49059 5.45874 4.44769 5.41 4.39401C5.30706 4.2805 5.25003 4.13275 5.25003 3.97951C5.25003 3.82627 5.30706 3.67852 5.41 3.56501L7.36 1.51501C7.50496 1.35609 7.68084 1.22844 7.87686 1.13988C8.07289 1.05133 8.28493 1.00373 8.5 1.00001H8.505ZM4.18 7.00001C3.707 7.00001 3.3 7.29401 3.208 7.70301L2.019 12.953C2.00771 13.0097 2.00135 13.0672 2 13.125C2 13.608 2.444 14 2.99 14H14.01C14.0753 14 14.14 13.9943 14.204 13.983C14.741 13.888 15.089 13.427 14.982 12.953L13.792 7.70301C13.7 7.29401 13.293 7.00001 12.822 7.00001H4.18ZM6 6.00001V7.00001H11V6.00001H12.825C13.771 6.00001 14.585 6.60601 14.771 7.44701L15.961 12.847C16.176 13.822 15.479 14.77 14.405 14.965C14.2765 14.9894 14.1458 15.0011 14.015 15H2.985C1.888 15 1 14.194 1 13.2C1 13.0807 1.013 12.963 1.039 12.847L2.229 7.44701C2.414 6.60601 3.229 6.00001 4.174 6.00001H6Z" fill="black"/>
            </svg>
          </div>
          <div class="card-trend">
            <i class="fas fa-arrow-up"></i>
            +8%
          </div>
        </div>
        
        <div class="card-body">
          <?php
            $stmt = $conn->prepare("SELECT * FROM comming WHERE STATUS = 0");
            $stmt ->execute();
            $tt = $stmt->rowCount();
           ?>
          <div class="card-number"><?php echo $tt ?></div>
          <h3 class="card-title">الأجهزة الصادرة</h3>
          <p class="card-subtitle">الأجهزة الموزعة والمرسلة</p>
          <div class="card-progress">
            <div class="progress-fill" style="width: 72%;"></div>
          </div>
        </div>
      </div>

      <!-- المستهلكات -->
      <div class="stat-card consumables" onclick="animateCard(this)">
        <div class="card-header">
          <div class="card-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M22.003 3V7.497C22.003 7.6304 21.95 7.75834 21.8557 7.85267C21.7613 7.94701 21.6334 8 21.5 8C21.4019 7.99902 21.3061 7.97034 21.2237 7.91726C21.1412 7.86417 21.0755 7.78886 21.034 7.7C20.2212 5.99353 18.9415 4.55235 17.3431 3.54351C15.7447 2.53467 13.8931 1.99949 12.003 2C6.81798 2 2.55398 5.947 2.05298 11" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M12 11V8M17 10V15C17 15.5304 16.7893 16.0391 16.4142 16.4142C16.0391 16.7893 15.5304 17 15 17H9C8.46957 17 7.96086 16.7893 7.58579 16.4142C7.21071 16.0391 7 15.5304 7 15V10C7 9.46957 7.21071 8.96086 7.58579 8.58579C7.96086 8.21071 8.46957 8 9 8H15C15.5304 8 16.0391 8.21071 16.4142 8.58579C16.7893 8.96086 17 9.46957 17 10Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M2.04999 21V16.503C2.04999 16.225 2.27599 16 2.55399 16C2.75399 16 2.93399 16.119 3.01999 16.3C3.83267 18.0063 5.11226 19.4474 6.71046 20.4562C8.30866 21.4651 10.16 22.0003 12.05 22C17.236 22 21.5 18.053 22.002 13" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          <div class="card-trend">
            <i class="fas fa-arrow-down" style="color: #ef4444;"></i>
            -3%
          </div>
        </div>
        
        <div class="card-body">
          <?php
            $stmt = $conn->prepare("SELECT * FROM consumers");
            $stmt ->execute();
            $tt = $stmt->rowCount();
           ?>
          <div class="card-number"><?php echo $tt ?></div>
          <h3 class="card-title">المستهلكات</h3>
          <p class="card-subtitle">المواد والقطع الاستهلاكية</p>
          <div class="card-progress">
            <div class="progress-fill" style="width: 58%;"></div>
          </div>
        </div>
      </div>

      <!-- المخزون -->
      <div class="stat-card inventory" onclick="animateCard(this)">
        <div class="card-header">
          <div class="card-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M5 20C5.55228 20 6 19.5523 6 19C6 18.4477 5.55228 18 5 18C4.44772 18 4 18.4477 4 19C4 19.5523 4.44772 20 5 20Z" fill="black"/>
              <path d="M4 4H6V13H4V4Z" fill="black"/>
              <path d="M7 2H3C2.73478 2 2.48043 2.10536 2.29289 2.29289C2.10536 2.48043 2 2.73478 2 3V21C2 21.2652 2.10536 21.5196 2.29289 21.7071C2.48043 21.8946 2.73478 22 3 22H7C7.26522 22 7.51957 21.8946 7.70711 21.7071C7.89464 21.5196 8 21.2652 8 21V3C8 2.73478 7.89464 2.48043 7.70711 2.29289C7.51957 2.10536 7.26522 2 7 2ZM7 21H3V3H7V21Z" fill="black"/>
              <path d="M12 20C12.5523 20 13 19.5523 13 19C13 18.4477 12.5523 18 12 18C11.4477 18 11 18.4477 11 19C11 19.5523 11.4477 20 12 20Z" fill="black"/>
              <path d="M11 4H13V13H11V4Z" fill="black"/>
              <path d="M14 2H10C9.73478 2 9.48043 2.10536 9.29289 2.29289C9.10536 2.48043 9 2.73478 9 3V21C9 21.2652 9.10536 21.5196 9.29289 21.7071C9.48043 21.8946 9.73478 22 10 22H14C14.2652 22 14.5196 21.8946 14.7071 21.7071C14.8946 21.5196 15 21.2652 15 21V3C15 2.73478 14.8946 2.48043 14.7071 2.29289C14.5196 2.10536 14.2652 2 14 2ZM14 21H10V3H14V21Z" fill="black"/>
              <path d="M19 20C19.5523 20 20 19.5523 20 19C20 18.4477 19.5523 18 19 18C18.4477 18 18 18.4477 18 19C18 19.5523 18.4477 20 19 20Z" fill="black"/>
              <path d="M18 4H20V13H18V4Z" fill="black"/>
              <path d="M21 2H17C16.7348 2 16.4804 2.10536 16.2929 2.29289C16.1054 2.48043 16 2.73478 16 3V21C16 21.2652 16.1054 21.5196 16.2929 21.7071C16.4804 21.8946 16.7348 22 17 22H21C21.2652 22 21.5196 21.8946 21.7071 21.7071C21.8946 21.5196 22 21.2652 22 21V3C22 2.73478 21.8946 2.48043 21.7071 2.29289C21.5196 2.10536 21.2652 2 21 2ZM21 21H17V3H21V21Z" fill="black"/>
            </svg>
          </div>
          <div class="card-trend">
            <i class="fas fa-arrow-up"></i>
            +15%
          </div>
        </div>
        
        <div class="card-body">
          <?php
            $stmt = $conn->prepare("SELECT * FROM products WHERE STATUS = 0");
            $stmt ->execute();
            $tt = $stmt->rowCount();
           ?>
          <div class="card-number"><?php echo $tt ?></div>
          <h3 class="card-title">المخزون</h3>
          <p class="card-subtitle">إجمالي المواد في المخزن</p>
          <div class="card-progress">
            <div class="progress-fill" style="width: 92%;"></div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
  // Animate progress bars on load
  window.addEventListener('load', function() {
    const progressBars = document.querySelectorAll('.progress-fill');
    progressBars.forEach(bar => {
      const width = bar.style.width;
      bar.style.width = '0%';
      setTimeout(() => {
        bar.style.width = width;
      }, 500);
    });
  });

  // Animate card on click
  function animateCard(card) {
    const number = card.querySelector('.card-number');
    number.classList.add('animate');
    setTimeout(() => {
      number.classList.remove('animate');
    }, 600);
  }

  // Add hover effects with JavaScript for better performance
  document.querySelectorAll('.stat-card').forEach(card => {
    card.addEventListener('mouseenter', function() {
      this.style.transform = 'translateY(-4px) scale(1.01)';
    });
    
    card.addEventListener('mouseleave', function() {
      this.style.transform = 'translateY(0) scale(1)';
    });
  });
</script>

</body>
</html>
    <?php
    include $tpl . 'footer.php';
  }else {
    header('location: index.php');

  }

 ?>
