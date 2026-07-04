<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
  <title>Dashboard FIK - Fakultas Industri Kreatif | Telkom University</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet" />

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: #ffffff;
      color: #1f2937;
    }

    :root {
      --orange: #f97316;
      --orange-dark: #ea580c;
      --orange-light: #ffedd5;
      --blue: #1e3a8a;
      --gray-bg: #f8fafc;
      --border: #e2e8f0;
    }

    .bg-orange-grad {
      background: linear-gradient(135deg, #f97316 0%, #fdba74 100%);
      position: relative;
    }

    .bg-orange-grad::before {
      content: "";
      position: absolute;
      inset: 0;
      background-image: radial-gradient(circle at 20% 30%, rgba(255,255,200,0.2) 2px, transparent 2.5px);
      background-size: 32px 32px;
      pointer-events: none;
    }

    .container-custom {
      width: min(100% - 3rem, 1280px);
      margin-inline: auto;
    }

    /* HEADER */
    .header-glass {
      position: fixed;
      top: 16px;
      left: 0;
      right: 0;
      z-index: 1000;
      transition: top 0.3s ease;
    }

    .navbar-glass {
      background: rgba(0, 0, 0, 0.55);
      backdrop-filter: blur(20px);
      border-radius: 60px;
      padding: 12px 32px;
      border: 1px solid rgba(255,255,255,0.15);
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      transition: all 0.3s ease;
    }

    .navbar-glass.scrolled {
      background: rgba(0, 0, 0, 0.88);
      backdrop-filter: blur(25px);
      box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    .logo-area {
      display: flex;
      align-items: center;
      gap: 16px;
    }

    .logo-icon {
      width: 48px;
      height: 48px;
      background: #2d3e50;
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: bold;
      font-size: 1.3rem;
    }

    .logo-text h5 {
      font-size: 0.9rem;
      font-weight: 800;
      color: white;
      margin: 0;
      line-height: 1.2;
    }

    .logo-text span {
      font-size: 0.7rem;
      color: rgba(255,255,255,0.85);
    }

    .nav-links {
      display: flex;
      gap: 2rem;
      align-items: center;
    }

    .nav-links a {
      color: white;
      text-decoration: none;
      font-weight: 600;
      font-size: 0.9rem;
      position: relative;
      padding-bottom: 4px;
    }

    .nav-links a::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 0%;
      height: 2px;
      background: var(--orange, #f97316);
      transition: 0.3s ease;
    }

    .nav-links a:hover::after,
    .nav-links a.active::after {
      width: 100%;
    }

    /* Dropdown Layanan */
    .dropdown-menu-custom {
      position: absolute;
      top: 100%;
      left: 0;
      margin-top: 15px;
      background: rgba(15, 23, 42, 0.95);
      backdrop-filter: blur(20px);
      border-radius: 20px;
      padding: 0.8rem 0;
      min-width: 240px;
      border: 1px solid rgba(255,255,255,0.15);
      opacity: 0;
      visibility: hidden;
      transform: translateY(-10px);
      transition: all 0.3s ease;
      z-index: 1000;
    }

    .nav-item-dropdown {
      position: relative;
    }

    .nav-item-dropdown:hover .dropdown-menu-custom {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }

    .dropdown-menu-custom a {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 20px;
      color: white;
      text-decoration: none;
      transition: all 0.2s ease;
      font-weight: 500;
      border-bottom: none !important;
    }

    .dropdown-menu-custom a::after {
      display: none;
    }

    .dropdown-menu-custom a:hover {
      background: rgba(249,115,22,0.3);
      color: var(--orange, #f97316);
      padding-left: 28px;
    }

    .dropdown-menu-custom i {
      width: 24px;
      font-size: 1.1rem;
      color: var(--orange, #f97316);
    }

    .dropdown-toggle-icon {
      margin-left: 6px;
      font-size: 0.7rem;
      transition: transform 0.3s ease;
    }

    .nav-item-dropdown:hover .dropdown-toggle-icon {
      transform: rotate(180deg);
    }

    /* Mobile Dropdown Override */
    @media (max-width: 768px) {
      .dropdown-menu-custom {
        position: static !important;
        transform: none !important;
        width: 100% !important;
        background: rgba(255,255,255,0.08) !important;
        border-radius: 14px !important;
        padding: 8px !important;
        box-shadow: none !important;
        border: 1px solid rgba(255,255,255,0.15) !important;
        opacity: 0;
        max-height: 0;
        overflow: hidden;
        transition: opacity 0.3s, max-height 0.4s !important;
        visibility: visible !important;
        margin-top: 5px;
      }
      
      .dropdown-menu-custom.show-mobile {
        opacity: 1 !important;
        max-height: 400px;
        display: block !important;
      }
      
      .dropdown-menu-custom a {
        padding: 10px 16px;
        color: rgba(255,255,255,0.85);
      }
      
      .dropdown-menu-custom a:hover {
        background: transparent;
        color: var(--orange, #f97316);
        padding-left: 28px;
      }
    }

    .btn-mytelu-custom {
      background: #f97316;
      padding: 8px 28px;
      border-radius: 40px;
      font-weight: 700;
      color: white;
      transition: 0.2s;
      text-decoration: none;
    }

    .btn-mytelu-custom:hover {
      background: #ea580c;
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(249, 115, 22, 0.3);
    }

    .mobile-toggle {
      display: none;
      background: rgba(255,255,255,0.15);
      border: 1px solid rgba(255,255,255,0.15);
      border-radius: 12px;
      padding: 8px 14px;
      font-size: 1.4rem;
      color: white;
      cursor: pointer;
      transition: all 0.3s ease;
      flex-shrink: 0;
    }

    .mobile-toggle:hover {
      background: rgba(255,255,255,0.25);
    }

    .navbar-right-group {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    /* Tombol tutup overlay - hanya tampil di mobile melalui position:absolute di dalam overlay */
    .nav-close-btn {
      display: none;
    }

    /* HERO SECTION */
    .hero-wrap {
      min-height: 100vh;
      padding-top: 160px;
      padding-bottom: 0;
    }

    /* Tambahan: pastikan body tidak overflow-x */
    body { overflow-x: hidden; }

    .hero-flex {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: center;
      gap: 40px;
    }

    .hero-title h1 {
      font-size: clamp(3rem, 7vw, 5.8rem);
      font-weight: 500;
      color: white;
      line-height: 1.1;
      max-width: 550px;
      letter-spacing: -0.02em;
    }

    .hero-image-area {
  width: 53%;
  background: transparent;
  backdrop-filter: none;
  border-radius: 0px;
  min-height: 550px;
  display: flex;
  align-items: center;
  justify-content: center;
  border: none;
  overflow: hidden;
  position: relative;
}

.hero-image-area img {
  width: 100%;
  height: auto;
  max-height: 550px;
  object-fit: contain;
  transition: transform 0.3s ease;
  border-radius: 0px;
}

    .hero-image-area img:hover {
      transform: scale(1.02);
    }

    .hero-image-placeholder {
      text-align: center;
      color: rgba(255,255,255,0.7);
      padding: 20px;
    }

    .hero-image-placeholder i {
      font-size: 3rem;
      margin-bottom: 10px;
      display: block;
    }

    /* FLOATING BADGES */
    .floating-card {
      position: absolute;
      background: white;
      border-radius: 24px;
      padding: 14px 24px;
      display: flex;
      gap: 16px;
      align-items: center;
      box-shadow: 0 20px 35px -12px rgba(0,0,0,0.2);
      z-index: 15;
      transition: transform 0.3s ease;
    }

    .floating-card:hover {
      transform: scale(1.03);
    }

    .badge-abs-1 { top: 15%; left: 52%; }
    .badge-abs-2 { top: 32%; right: 2%; }
    .badge-abs-3 { top: 44%; left: 46%; }

    .badge-icon-orange {
      width: 52px;
      height: 52px;
      background: #fff0e2;
      border-radius: 60px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.9rem;
      color: #f97316;
    }

    /* ACHIEVEMENT CARD */
    .achievement-master {
      background: #f97316;
      border-radius: 48px 48px 0 0;
      margin-top: 0;
      padding: 48px 56px;
      color: white;
      box-shadow: 0 -10px 30px rgba(0,0,0,0.1);
      position: relative;
      z-index: 10;
    }

    .achievement-title {
      font-size: 2rem;
      font-weight: 800;
      margin-bottom: 48px;
      display: flex;
      gap: 12px;
      align-items: center;
    }

    .stats-three-col {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 48px;
    }

    .big-number {
      font-size: 2.8rem;
      font-weight: 800;
      line-height: 1.2;
      font-family: monospace;
      letter-spacing: 2px;
    }

    .winner-avatar {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      background: rgba(255,255,255,0.3);
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      flex-shrink: 0;
    }

    .winner-avatar i {
      font-size: 2rem;
      color: rgba(255,255,255,0.8);
    }

    .winner-row {
      display: flex;
      flex-direction: column;
      gap: 32px;
    }

    .winner-item-flex {
      display: flex;
      gap: 20px;
      align-items: center;
    }

    /* DIREKTORAT - Updated with image */
.direktorat-card {
  background: white;
  border-radius: 32px;
  box-shadow: 0 8px 30px rgba(0,0,0,0.06);
  margin: 70px auto;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 32px;
  overflow: hidden;
  transition: transform 0.3s ease;
}

.direktorat-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 16px 48px rgba(0,0,0,0.1);
}

.direktorat-img-area {
  background: #eef2ff;
  min-height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}

.direktorat-img-area img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  min-height: 300px;
}

    /* BERITA CAROUSEL */
    .berita-carousel-container {
      position: relative;
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px 60px;
      overflow: hidden;
    }

    .berita-carousel {
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 500px;
    }

    .berita-card {
      position: absolute;
      width: 380px;
      background: white;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 20px 40px rgba(0,0,0,0.15);
      transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
      cursor: pointer;
    }

    .berita-card.active {
      z-index: 30;
      opacity: 1;
      transform: translateX(0) scale(1);
      filter: blur(0);
      width: 420px;
    }

    .berita-card.right {
      transform: translateX(320px) scale(0.85);
      opacity: 0.9;
      filter: blur(2px);
      z-index: 20;
    }

    .berita-card.left {
      transform: translateX(-320px) scale(0.85);
      opacity: 0.9;
      filter: blur(2px);
      z-index: 20;
    }

    .berita-card.right-far {
      transform: translateX(580px) scale(0.7);
      opacity: 0;
      filter: blur(4px);
      z-index: 10;
      pointer-events: none;
    }

    .berita-card.left-far {
      transform: translateX(-580px) scale(0.7);
      opacity: 0;
      filter: blur(4px);
      z-index: 10;
      pointer-events: none;
    }

    .berita-card-inner {
      height: 100%;
      display: flex;
      flex-direction: column;
    }

    .berita-image {
      height: 220px;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #fef3c7 0%, #ffedd5 100%);
    }

    .berita-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.3s ease;
    }

    .berita-card:hover .berita-image img {
      transform: scale(1.05);
    }

    .berita-content {
      padding: 24px;
      flex: 1;
    }

    .berita-category {
      display: inline-block;
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 0.7rem;
      font-weight: 600;
      margin-bottom: 12px;
    }

    .berita-category.berita {
      background: #dbeafe;
      color: #1e40af;
    }

    .berita-category.pengumuman {
      background: #fed7aa;
      color: #9a3412;
    }

    .berita-category.artikel {
      background: #dcfce7;
      color: #166534;
    }

    .berita-title {
      font-size: 1.2rem;
      font-weight: 800;
      margin-bottom: 12px;
      line-height: 1.4;
      color: #1f2937;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .berita-meta {
      display: flex;
      gap: 16px;
      font-size: 0.75rem;
      color: #6b7280;
      margin-bottom: 16px;
    }

    .berita-meta i {
      margin-right: 4px;
    }

    .berita-excerpt {
      font-size: 0.85rem;
      color: #6b7280;
      line-height: 1.5;
      margin-bottom: 20px;
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .berita-readmore {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      color: #f97316;
      font-weight: 600;
      font-size: 0.85rem;
      text-decoration: none;
      transition: gap 0.3s ease;
    }

    .berita-readmore:hover {
      gap: 12px;
      color: #ea580c;
    }

    .carousel-nav {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      width: 48px;
      height: 48px;
      border-radius: 50%;
      background: white;
      border: none;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      cursor: pointer;
      transition: all 0.3s ease;
      z-index: 40;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .carousel-nav:hover {
      background: #f97316;
      color: white;
      box-shadow: 0 6px 16px rgba(249,115,22,0.3);
      transform: scale(1.05);
    }

    .carousel-nav.prev {
      left: 0;
    }

    .carousel-nav.next {
      right: 0;
    }

    .carousel-nav i {
      font-size: 1.2rem;
    }

    .carousel-dots {
      display: flex;
      justify-content: center;
      gap: 12px;
      margin-top: 40px;
    }

    .dot {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      background: #cbd5e1;
      border: none;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .dot.active {
      width: 30px;
      border-radius: 10px;
      background: #f97316;
    }

    /* ORGANISASI SECTION */
    .org-bg-orange {
      position: relative;
      padding: 80px 0;
      color: white;
      overflow: hidden;
      background: linear-gradient(135deg, #f97316 0%, #fdba74 100%);
      background-blend-mode: overlay;
    }
    
    .org-bg-orange::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-image: url('https://www.transparenttextures.com/patterns/cubes.png');
      background-repeat: repeat;
      background-size: 60px;
      opacity: 0.12;
      pointer-events: none;
      z-index: 0;
    }
    
    .org-bg-orange::after {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-image: radial-gradient(circle at 20% 40%, rgba(255,255,200,0.15) 2px, transparent 2.5px);
      background-size: 35px 35px;
      pointer-events: none;
      z-index: 0;
    }
    
    .org-bg-orange .container-custom {
      position: relative;
      z-index: 2;
    }

    .org-layout {
      display: flex;
      align-items: flex-start;
      gap: 50px;
    }

    .org-left {
      flex: 0 0 320px;
      position: sticky;
      top: 100px;
    }

    .org-section-title {
      font-size: 2.6rem;
      font-weight: 800;
      line-height: 1.2;
      margin-bottom: 16px;
      color: white;
    }

    .org-section-subtitle {
      font-size: 0.9rem;
      color: rgba(255,255,255,0.85);
      line-height: 1.5;
    }

    .org-right {
      flex: 1;
      display: flex;
      gap: 25px;
    }

    .org-col-left {
      flex: 1;
      position: relative;
      height: 550px;
      overflow: hidden;
    }

    .org-col-right {
      flex: 1;
      position: relative;
      height: 550px;
      overflow: hidden;
    }

    .org-scroll-up-wrapper {
      position: relative;
      width: 100%;
      height: 100%;
    }

    .org-scroll-up-content {
      position: absolute;
      width: 100%;
      animation: scrollUp 25s linear infinite;
    }

    .org-scroll-up-content:hover {
      animation-play-state: paused;
    }

    @keyframes scrollUp {
      0% { transform: translateY(0); }
      100% { transform: translateY(-50%); }
    }

    .org-scroll-down-wrapper {
      position: relative;
      width: 100%;
      height: 100%;
    }

    .org-scroll-down-content {
      position: absolute;
      width: 100%;
      animation: scrollDown 25s linear infinite;
    }

    .org-scroll-down-content:hover {
      animation-play-state: paused;
    }

    @keyframes scrollDown {
      0% { transform: translateY(-50%); }
      100% { transform: translateY(0); }
    }

    .org-grid-one {
      display: grid;
      grid-template-columns: 1fr;
      gap: 18px;
      margin-bottom: 18px;
    }

    .org-card {
      background: white;
      border-radius: 14px;
      padding: 14px 16px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .org-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 22px rgba(0,0,0,0.12);
    }

    .org-logo {
      width: 48px;
      height: 48px;
      min-width: 48px;
      background: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: transform 0.3s ease;
      overflow: hidden;
    }

    .org-card:hover .org-logo {
      transform: scale(1.05);
    }

    .org-logo img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .org-logo.no-image {
      background: linear-gradient(135deg, #ffedd5 0%, #fff7ed 100%);
    }

    .org-logo.no-image i {
      font-size: 1.4rem;
      color: #f97316;
    }

    .org-info {
      flex: 1;
    }

    .org-info h3 {
      font-size: 0.9rem;
      font-weight: 800;
      margin: 0 0 4px 0;
      color: #1f2937;
    }

    .org-info p {
      font-size: 0.72rem;
      color: #6b7280;
      line-height: 1.35;
      margin: 0;
    }

    /* INTERNATIONAL RECOGNITIONS */
    .recognition-section {
      background: white;
      padding: 80px 0;
      text-align: center;
    }

    .recognition-title {
      font-size: 2.5rem;
      font-weight: 800;
      color: #1e3a8a;
      margin-bottom: 16px;
    }

    .recognition-subtitle {
      font-size: 1.1rem;
      color: #4b5563;
      margin-bottom: 48px;
      line-height: 1.5;
    }

    .recognition-logos {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 30px;
      max-width: 1100px;
      margin: 0 auto;
    }

    .recognition-item {
      background: #f8fafc;
      padding: 20px 25px;
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      transition: all 0.3s ease;
      border: 1px solid #e2e8f0;
      min-width: 150px;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 12px;
    }

    .recognition-item:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 24px rgba(0,0,0,0.1);
      border-color: #f97316;
    }

    .recognition-item img {
      max-width: 120px;
      max-height: 60px;
      object-fit: contain;
    }

    .recognition-item span {
      font-size: 0.8rem;
      font-weight: 600;
      color: #1f2937;
      text-align: center;
    }

    /* ALUMNI QUOTE */
    .alumni-quote-section {
      position: relative;
      padding: 100px 0;
      color: white;
      overflow: hidden;
      background: linear-gradient(135deg, #f97316 0%, #fdba74 100%);
      background-blend-mode: overlay;
      width: 100%;
      margin: 0;
    }
    
    .alumni-quote-section::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-image: url('https://www.transparenttextures.com/patterns/cartographer.png');
      background-repeat: repeat;
      background-size: 80px;
      opacity: 0.15;
      pointer-events: none;
      z-index: 0;
    }
    
    .alumni-quote-section::after {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-image: radial-gradient(circle at 30% 50%, rgba(255,255,200,0.12) 2px, transparent 2.5px);
      background-size: 40px 40px;
      pointer-events: none;
      z-index: 0;
    }
    
    .alumni-quote-section .container-custom {
      position: relative;
      z-index: 2;
      width: 100%;
      max-width: 1280px;
      margin: 0 auto;
      padding: 0 3rem;
    }
    
    .alumni-quote-content {
      max-width: 100%;
      margin: 0;
      text-align: left;
    }
    
    .alumni-quote-section h2 {
      font-size: 3rem;
      font-weight: 800;
      margin-bottom: 16px;
      letter-spacing: -0.02em;
      text-align: left;
    }
    
    .alumni-quote-section p {
      font-size: 1.3rem;
      font-weight: 500;
      opacity: 0.95;
      margin: 0;
      text-align: left;
    }
    
    .quote-icon {
      font-size: 3rem;
      opacity: 0.25;
      margin-bottom: 16px;
      text-align: left;
    }

    /* MITRA KERJASAMA */
    .partner-section {
      padding: 80px 0;
      background: white;
    }

    .partner-layout {
      display: flex;
      align-items: center;
      gap: 60px;
      flex-wrap: wrap;
    }

    .partner-logos {
      flex: 1;
      min-width: 280px;
    }

    .partner-logos-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 25px;
      align-items: center;
    }

    .partner-logo-item {
      background: #f8fafc;
      border-radius: 16px;
      padding: 20px;
      text-align: center;
      transition: all 0.3s ease;
      border: 1px solid #e2e8f0;
      cursor: pointer;
      min-height: 100px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .partner-logo-item:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 24px rgba(0,0,0,0.1);
      border-color: #f97316;
    }

    .partner-logo-item img {
      max-width: 100%;
      max-height: 70px;
      object-fit: contain;
    }

    .partner-content {
      flex: 1;
      min-width: 280px;
    }

    .partner-content h2 {
      font-size: 2.5rem;
      font-weight: 800;
      color: #1e3a8a;
      margin-bottom: 20px;
    }

    .partner-content p {
      font-size: 1rem;
      color: #4b5563;
      line-height: 1.6;
      margin-bottom: 30px;
    }

    .partner-content .btn-partner {
      background: #f97316;
      color: white;
      padding: 12px 32px;
      border-radius: 40px;
      font-weight: 600;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      transition: all 0.3s ease;
      border: none;
    }

    .partner-content .btn-partner:hover {
      background: #ea580c;
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(249, 115, 22, 0.25);
    }

    footer {
      background: linear-gradient(135deg, #f97316 0%, #fdba74 100%);
      height: 80px;
    }

    @media (max-width: 1024px) {
      .stats-three-col { grid-template-columns: 1fr; gap: 28px; }
      .direktorat-card { grid-template-columns: 1fr; }
      .badge-abs-1, .badge-abs-2, .badge-abs-3 { display: none; }
      .org-layout { flex-direction: column; gap: 30px; }
      .org-left { flex: auto; position: static; text-align: center; }
      .org-section-title { font-size: 2rem; text-align: center; }
      .org-right { flex-direction: column; gap: 30px; }
      .org-col-left, .org-col-right { height: 400px; }
      .recognition-title { font-size: 2rem; }
      .alumni-quote-section h2 { font-size: 2.5rem; }
      .alumni-quote-section p { font-size: 1.2rem; }
      .alumni-quote-section { padding: 80px 0; }
      .partner-layout { flex-direction: column; text-align: center; }
      .partner-content { text-align: center; }
      .partner-content h2 { text-align: center; }
      .hero-flex { flex-direction: column; text-align: center; }
      .hero-title h1 { text-align: center; margin: 0 auto; }
      .hero-image-area { width: 80%; margin: 0 auto; min-height: 350px; }
      .achievement-master { border-radius: 32px; margin-top: 30px; }
      .recognition-logos { gap: 20px; }
      .recognition-item { padding: 15px 20px; min-width: 130px; }
    }

    @media (max-width: 768px) {
      /* ===== NAVBAR MOBILE ===== */
      .navbar-glass {
        flex-direction: row;
        flex-wrap: wrap;
        padding: 12px 20px;
      }
      .navbar-glass.scrolled {
        border-radius: 60px;
      }
      .logo-area { order: 1; }
      .navbar-right-group {
        order: 2;
        display: flex;
        align-items: center;
        gap: 8px;
      }
      .nav-links {
        order: 3;
        display: none;
        width: 100%;
        flex-direction: column;
        margin-top: 12px;
        gap: 16px;
        align-items: flex-start;
      }
      .nav-links.open { display: flex !important; }
      .nav-links a {
        font-size: 1rem;
        color: white;
      }
      .nav-close-btn { display: none !important; }
      .mobile-toggle { display: block; }
      .btn-mytelu-custom {
        padding: 7px 14px;
        font-size: 0.8rem;
        gap: 6px;
      }
      /* ===== HERO SECTION MOBILE ===== */
      .hero-wrap { padding-top: 120px; }
      .hero-flex { flex-direction: column; text-align: center; gap: 20px; }
      .hero-title h1 { font-weight: 500; text-align: center; margin: 0 auto; font-size: clamp(2rem, 9vw, 3.5rem); }
      .hero-image-area { width: 100%; margin-top: 10px; min-height: 220px; }
      /* ===== ACHIEVEMENT SECTION ===== */
      .achievement-master { margin-top: 0; padding: 28px 18px; }
      .stats-three-col { grid-template-columns: 1fr; gap: 24px; }
      .big-number { font-size: 2rem; }
      .achievement-title { font-size: 1.4rem; margin-bottom: 24px; }
      .d-flex.gap-5 { gap: 1.5rem !important; }
      /* ===== BERITA CAROUSEL MOBILE: tampil list scroll ===== */
      .berita-carousel-container {
        padding: 20px 0;
        overflow: visible;
      }
      .berita-carousel {
        display: flex;
        flex-direction: row;
        min-height: unset;
        gap: 20px;
        align-items: stretch;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
        padding: 0 16px 12px;
        scrollbar-width: none;
      }
      .berita-carousel::-webkit-scrollbar { display: none; }
      .berita-card {
        position: relative !important;
        width: calc(85vw) !important;
        min-width: calc(85vw);
        margin-bottom: 0;
        transform: none !important;
        opacity: 1 !important;
        filter: none !important;
        z-index: 1 !important;
        scroll-snap-align: start;
        flex-shrink: 0;
      }
      .berita-card.active, .berita-card.left, .berita-card.right,
      .berita-card.left-far, .berita-card.right-far {
        position: relative !important;
        transform: none !important;
        opacity: 1 !important;
        filter: none !important;
        width: calc(85vw) !important;
      }
      .carousel-nav { display: none !important; }
      .carousel-dots { display: none !important; }
      /* ===== DIREKTORAT CARD ===== */
      .direktorat-card { grid-template-columns: 1fr; margin: 30px auto; }
      .direktorat-img-area img { min-height: 200px; }
      /* ===== ORG SECTION ===== */
      .org-layout { flex-direction: column; gap: 24px; }
      .org-left { flex: auto; position: static; text-align: center; }
      .org-section-title { font-size: 1.6rem; text-align: center; }
      .org-right { flex-direction: column; gap: 20px; }
      .org-col-left, .org-col-right { height: 350px; }
      .org-card { padding: 12px 14px; }
      .org-logo { width: 42px; height: 42px; min-width: 42px; }
      .org-info h3 { font-size: 0.85rem; }
      .org-info p { font-size: 0.68rem; }
      /* ===== RECOGNITION SECTION ===== */
      .recognition-title { font-size: 1.6rem; }
      .recognition-subtitle { font-size: 0.9rem; }
      .recognition-logos { gap: 15px; }
      .recognition-item { padding: 12px 15px; min-width: 90px; }
      .recognition-item img { max-height: 35px; }
      .recognition-item span { font-size: 0.7rem; }
      /* ===== ALUMNI QUOTE ===== */
      .alumni-quote-section { padding: 60px 0; }
      .alumni-quote-section h2 { font-size: 1.8rem; }
      .alumni-quote-section p { font-size: 0.95rem; }
      .alumni-quote-section .container-custom { padding: 0 1.5rem; }
      .quote-icon { font-size: 2rem; }
      /* ===== PARTNER SECTION ===== */
      .partner-section { padding: 50px 0; }
      .partner-layout { flex-direction: column; text-align: center; gap: 30px; }
      .partner-content { text-align: center; }
      .partner-content h2 { font-size: 1.8rem; text-align: center; }
      .partner-content p { font-size: 0.9rem; }
      .partner-logos-grid { gap: 12px; }
      .partner-logo-item { padding: 15px; min-height: 80px; }
      .partner-logo-item img { max-height: 50px; }
      /* ===== DROPDOWN MOBILE: list sederhana ===== */
      .dropdown-menu-custom {
        position: static !important;
        transform: none !important;
        width: 100% !important;
        max-width: 100% !important;
        left: auto !important;
        background: rgba(255,255,255,0.08) !important;
        border-radius: 16px !important;
        padding: 8px !important;
        box-shadow: none !important;
        border: 1px solid rgba(255,255,255,0.1) !important;
        opacity: 0;
        max-height: 0;
        overflow: hidden;
        transition: opacity 0.3s ease, max-height 0.4s ease !important;
        visibility: visible !important;
      }
      .dropdown-wrapper.open .dropdown-menu-custom {
        opacity: 1 !important;
        max-height: 600px;
        animation: none !important;
      }
      .dropdown-grid {
        grid-template-columns: 1fr 1fr !important;
        gap: 6px !important;
      }
      .dropdown-item {
        padding: 14px 8px !important;
        min-height: 100px !important;
        background: rgba(255,255,255,0.06) !important;
        color: white !important;
      }
      .dropdown-item .d-title { color: white !important; font-size: 0.75rem; }
      .dropdown-item .d-desc { color: rgba(255,255,255,0.65) !important; font-size: 0.62rem; }
      .dropdown-item .d-icon-wrapper { background: rgba(255,255,255,0.1) !important; width: 40px; height: 40px; }
    }

    @media (max-width: 420px) {
      .navbar-glass { padding: 8px 10px; }
      .logo-text h5 { font-size: 0.78rem; }
      .logo-text span { font-size: 0.62rem; }
      .logo-icon { width: 38px; height: 38px; font-size: 1rem; }
      .btn-mytelu-custom { padding: 6px 10px; font-size: 0.75rem; gap: 4px; }
      .user-avatar-small { width: 24px !important; height: 24px !important; }
      .berita-card { width: calc(92vw) !important; min-width: calc(92vw); }
      .berita-card.active, .berita-card.left, .berita-card.right,
      .berita-card.left-far, .berita-card.right-far { width: calc(92vw) !important; }
      .recognition-item { min-width: 80px; }
    }

    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateX(-50%) translateY(-12px) scale(0.96);
      }
      to {
        opacity: 1;
        transform: translateX(-50%) translateY(0) scale(1);
      }
    }

    .dropdown-wrapper.open .dropdown-menu-custom {
      animation: slideDown 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    /* ==================== BERITA CAROUSEL ==================== */
.berita-carousel-container {
    position: relative;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px 60px;
    overflow: hidden;
}

.berita-carousel {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 500px;
}

.berita-card {
    position: absolute;
    width: 380px;
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
}

/* Card tengah (aktif) */
.berita-card.active {
    z-index: 30;
    opacity: 1;
    transform: translateX(0) scale(1);
    filter: blur(0);
    width: 420px;
}

/* Card kanan (posisi 1) */
.berita-card.right {
    transform: translateX(320px) scale(0.85);
    opacity: 0.9;
    filter: blur(2px);
    z-index: 20;
    cursor: pointer;
}

/* Card kiri (posisi -1) */
.berita-card.left {
    transform: translateX(-320px) scale(0.85);
    opacity: 0.9;
    filter: blur(2px);
    z-index: 20;
    cursor: pointer;
}

/* Card jauh kanan */
.berita-card.right-far {
    transform: translateX(580px) scale(0.7);
    opacity: 0;
    filter: blur(4px);
    z-index: 10;
    pointer-events: none;
}

/* Card jauh kiri */
.berita-card.left-far {
    transform: translateX(-580px) scale(0.7);
    opacity: 0;
    filter: blur(4px);
    z-index: 10;
    pointer-events: none;
}

.berita-card-inner {
    height: 100%;
    display: flex;
    flex-direction: column;
}

.berita-image {
    height: 220px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #fef3c7 0%, #ffedd5 100%);
}

.berita-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.berita-card:hover .berita-image img {
    transform: scale(1.05);
}

.berita-content {
    padding: 24px;
    flex: 1;
}

.berita-category {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
    margin-bottom: 12px;
}

.berita-category.berita {
    background: #dbeafe;
    color: #1e40af;
}

.berita-category.pengumuman {
    background: #fed7aa;
    color: #9a3412;
}

.berita-category.artikel {
    background: #dcfce7;
    color: #166534;
}

.berita-title {
    font-size: 1.2rem;
    font-weight: 800;
    margin-bottom: 12px;
    line-height: 1.4;
    color: #1f2937;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.berita-meta {
    display: flex;
    gap: 16px;
    font-size: 0.75rem;
    color: #6b7280;
    margin-bottom: 16px;
}

.berita-meta i {
    margin-right: 4px;
}

.berita-excerpt {
    font-size: 0.85rem;
    color: #6b7280;
    line-height: 1.5;
    margin-bottom: 20px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.berita-readmore {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #f97316;
    font-weight: 600;
    font-size: 0.85rem;
    text-decoration: none;
    transition: gap 0.3s ease;
}

.berita-readmore:hover {
    gap: 12px;
    color: #ea580c;
}

/* Tombol Navigasi */
.carousel-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: white;
    border: none;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 40;
    display: flex;
    align-items: center;
    justify-content: center;
}

.carousel-nav:hover {
    background: #f97316;
    color: white;
    box-shadow: 0 6px 16px rgba(249,115,22,0.3);
}

.carousel-nav.prev {
    left: 0;
}

.carousel-nav.next {
    right: 0;
}

.carousel-nav i {
    font-size: 1.2rem;
}

/* Dots Indicator */
.carousel-dots {
    display: flex;
    justify-content: center;
    gap: 12px;
    margin-top: 40px;
}

.dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #cbd5e1;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.dot.active {
    width: 30px;
    border-radius: 10px;
    background: #f97316;
}

/* Responsive */
@media (max-width: 1024px) {
    .berita-carousel-container {
        padding: 20px 40px;
    }
    
    .berita-card {
        width: 320px;
    }
    
    .berita-card.active {
        width: 360px;
    }
    
    .berita-card.right {
        transform: translateX(280px) scale(0.85);
    }
    
    .berita-card.left {
        transform: translateX(-280px) scale(0.85);
    }
}

@media (max-width: 768px) {
    .berita-carousel-container {
        padding: 20px 0;
        overflow: visible;
    }

    .berita-carousel {
        display: flex;
        flex-direction: row;
        min-height: unset;
        gap: 16px;
        align-items: stretch;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
        padding: 0 16px 12px;
        scrollbar-width: none;
    }

    .berita-carousel::-webkit-scrollbar { display: none; }

    .berita-card {
        position: relative !important;
        width: calc(85vw) !important;
        min-width: calc(85vw);
        margin-bottom: 0;
        transform: none !important;
        opacity: 1 !important;
        filter: none !important;
        z-index: 1 !important;
        scroll-snap-align: start;
        flex-shrink: 0;
    }
    
    .berita-card.active,
    .berita-card.right,
    .berita-card.left,
    .berita-card.left-far,
    .berita-card.right-far {
        position: relative !important;
        transform: none !important;
        opacity: 1 !important;
        filter: none !important;
        width: calc(85vw) !important;
    }
    
    .carousel-nav {
        display: none !important;
    }
    
    .carousel-dots {
        display: none !important;
    }
}
  </style>
<style>
  /* ===== BERITA SECTION ===== */
  .berita-section {
    padding: 80px 0 60px;
    background: #f8fafc;
  }

  @media (max-width: 768px) {
    .berita-section {
      padding: 50px 0 40px;
    }
    .direktorat-card .p-5 {
      padding: 24px !important;
    }
    .direktorat-card h2 {
      font-size: 1.4rem;
    }
    .direktorat-card p {
      font-size: 0.88rem;
    }
  }
</style>
</head>
<body>
<header class="header-glass" id="mainHeader">
  <div class="container-custom">
    <div class="navbar-glass" id="navbar">
      <div class="logo-area">
        <div class="logo-icon"><i class="fas fa-palette"></i></div>
        <div class="logo-text">
          <h5>Unit Kemahasiswaan</h5>
          <span>Fakultas Industri Kreatif</span>
        </div>
      </div>
      
      <!-- Nav links -->
      <div class="nav-links" id="navLinks">

        <a href="<?= base_url() ?>" class="active">Dashboard</a>
        <a href="<?= base_url('berita') ?>">Informasi</a>
        
        <!-- Dropdown Layanan -->
        <div class="nav-item-dropdown">
            <a href="#" class="dropdown-toggle">
                Layanan <i class="fas fa-chevron-down dropdown-toggle-icon"></i>
            </a>
            <div class="dropdown-menu-custom" id="layananDropdown">
                <a href="<?= base_url('beasiswa') ?>">
                    <i class="fas fa-graduation-cap"></i> Pengajuan Beasiswa
                </a>
                <a href="<?= base_url('sertifikat') ?>">
                    <i class="fas fa-certificate"></i> Pengajuan Sertifikat
                </a>
                <a href="<?= base_url('proposal') ?>">
                    <i class="fas fa-file-alt"></i> Pengajuan Proposal
                </a>
                <a href="<?= base_url('tak') ?>">
                    <i class="fas fa-clipboard-list"></i> Pengajuan TAK
                </a>
                <a href="<?= base_url('forum_alumni') ?>">
                    <i class="fas fa-users"></i> Layanan Alumni
                </a>
            </div>
        </div>
        
        <a href="<?= base_url('forum_alumni') ?>">Forum Alumni</a>
      </div>
      
      <?php if(isset($user_data) && $user_data && $user_data['logged_in']): ?>
      <div class="navbar-right-group">
        <a href="<?= base_url('dashboard/profile') ?>" class="btn-mytelu-custom">
          <?php if(!empty($user_data['foto'])): ?>
            <img src="<?= base_url('uploads/users/' . $user_data['foto']) ?>" class="user-avatar-small" style="width:28px; height:28px; border-radius:50%; object-fit:cover;">
          <?php else: ?>
            <i class="fas fa-user-circle"></i>
          <?php endif; ?>
          <?= htmlspecialchars($user_data['nama']) ?>
        </a>
      <?php else: ?>
      <div class="navbar-right-group">
        <a href="<?= base_url('login') ?>" class="btn-mytelu-custom">
          <i class="fas fa-sign-in-alt"></i> MyTeLU
        </a>
      <?php endif; ?>
      
      <button class="mobile-toggle" id="mobileNavBtn"><i class="fas fa-bars"></i></button>
      </div>
    </div>
  </div>
</header>

<main>
  <!-- Hero Section -->
  <section class="bg-orange-grad hero-wrap" id="homeSection">
    <div class="container-custom hero-flex">
      <div class="hero-title">
        <h1>Sesuaikan Ke<br>kebutuhanmu</h1>
      </div>
      
      <div class="hero-image-area">
  <img id="heroStudentImage" src="<?= base_url('assets/mahasiswa.png') ?>" alt="Foto Mahasiswa" style="width:100%; height:100%; object-fit:cover; border-radius:0px;" onerror="this.onerror=null; this.style.display='none'; document.getElementById('heroFallback').style.display='flex'">
  <div id="heroFallback" class="hero-image-placeholder" style="display:none; flex-direction:column;">
    <i class="fas fa-user-graduate"></i>
    <p>Foto Mahasiswa Kreatif</p>
    <p style="font-size:12px;">Letakkan mahasiswa.png di folder assets/</p>
  </div>
</div>

      <div class="floating-card badge-abs-1">
        <div class="badge-icon-orange"><i class="fas fa-certificate"></i></div>
        <div><strong>Complete chapters</strong><br>to earn certificates</div>
      </div>
      
      <div class="floating-card badge-abs-2">
        <div class="badge-icon-orange"><i class="fas fa-users"></i></div>
        <div><strong>Forum Alumni</strong><br>Jaringan profesional</div>
      </div>
      
      <div class="floating-card badge-abs-3">
        <div class="badge-icon-orange"><i class="fas fa-chalkboard"></i></div>
        <div><strong>MyTeLU</strong><br>Dashboard interaktif</div>
      </div>
    </div>

    <div class="container-custom" style="padding: 0;">
      <div class="achievement-master" id="achievementCard">
        <div class="achievement-title">
          Mahasiswa Berprestasi <i class="fas fa-arrow-right"></i>
        </div>
        <div class="stats-three-col">
          <div>
            <div class="big-number" id="activeStudents">0</div>
            <div>Mahasiswa Aktif<br>Berdasarkan MR 2025 ganjil<br>Keadaan Tanggal 30 Oktober 2025</div>
            <div class="big-number mt-4" id="countryCount">0</div>
            <div>Negara</div>
          </div>
          
          <div class="winner-row">
            <div class="winner-item-flex">
              <div class="winner-avatar"><i class="fas fa-trophy"></i></div>
              <div>Juara 1 Kategori Ilustrasi Digital dan Juara 3 Kategori Motion Graphic dalam Festival Kreatif Mahasiswa 2025 Cabang Desain Komunikasi Visual, Bandung.</div>
            </div>
            <div class="winner-item-flex">
              <div class="winner-avatar"><i class="fas fa-camera-retro"></i></div>
              <div>Juara 3 Kategori Fotografi Komersial dan Juara 2 Kategori Desain Konten Media Sosial dalam Creative Student Award 2025 Cabang Desain Komunikasi Visual, Malang.</div>
            </div>
          </div>
          
          <div>
            <div class="big-number" id="alumniCount">0</div>
            <div>Alumni<br>Berdasarkan MR 2024</div>
            <div class="d-flex gap-5 mt-4">
              <div><span class="big-number" id="teluDaerah">0</span><br>TelU Daerah</div>
              <div><span class="big-number" id="teluLuar">0</span><br>TelU Luar Negeri</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- DIREKTORAT -->
  <div class="container-custom">
    <div class="direktorat-card">
      <div class="direktorat-img-area">
  <img src="<?= base_url('assets/Direktorat.png') ?>" alt="Direktorat Kemahasiswaan" onerror="...">
</div>
      <div class="p-5">
        <h2 class="fw-bold">Direktorat Kemahasiswaan, Karier, dan Alumni</h2>
        <p class="mt-3">Direktorat Kemahasiswaan, Karier dan Alumni (KKA) merupakan Direktorat yang berfungsi mengelola prestasi, kegiatan mahasiswa, pengembangan karakter, kesejahteraan mahasiswa, pengembangan Karier dan kontribusi alumni. Dengan keberadaan Direktorat KKA diharapkan seluruh mahasiswa dapat mengembangkan minat dan bakat sehingga dapat meningkatkan kompetensi khususnya dalam mempersiapkan diri dalam memasuki dunia kerja.</p>
        <a href="#" class="btn btn-outline-dark rounded-pill px-4">Selengkapnya <i class="fas fa-arrow-right"></i></a>
      </div>
    </div>
  </div>

<!-- BERITA SECTION -->
<section class="berita-section">
    <div class="container-custom">
        <h2 class="display-5 fw-bold mb-2 text-center">BERITA</h2>
        <p class="text-muted mb-5 text-center">Informasi terbaru dari Fakultas Industri Kreatif</p>
        
        <?php if (isset($berita_list) && !empty($berita_list)): ?>
        <!-- Carousel Berita -->
        <div class="berita-carousel-container">
            <div class="berita-carousel">
                <?php foreach ($berita_list as $index => $item): ?>
                <div class="berita-card <?= $index == 0 ? 'active' : ($index == 1 ? 'right' : '') ?>" data-id="<?= $item['id'] ?>" data-slug="<?= $item['slug'] ?>">
                    <div class="berita-card-inner">
                        <?php if(!empty($item['gambar']) && file_exists('uploads/berita/' . $item['gambar'])): ?>
                            <div class="berita-image">
                                <img src="<?= base_url('uploads/berita/' . $item['gambar']) ?>" alt="<?= htmlspecialchars($item['judul']) ?>">
                            </div>
                        <?php else: ?>
                            <div class="berita-image bg-light">
                                <i class="fas fa-newspaper fa-4x text-muted"></i>
                            </div>
                        <?php endif; ?>
                        <div class="berita-content">
                            <span class="berita-category <?= $item['kategori'] ?>">
                                <?= ucfirst($item['kategori']) ?>
                            </span>
                            <h3 class="berita-title"><?= htmlspecialchars($item['judul']) ?></h3>
                            <div class="berita-meta">
                                <span><i class="far fa-calendar-alt"></i> <?= date('d F Y', strtotime($item['published_at'])) ?></span>
                                <span><i class="fas fa-eye"></i> <?= number_format($item['views']) ?> views</span>
                            </div>
                            <p class="berita-excerpt"><?= htmlspecialchars(strip_tags(substr($item['ringkasan'] ?: $item['konten'], 0, 120))) ?>...</p>
                            <a href="<?= base_url('berita/detail/' . $item['slug']) ?>" class="berita-readmore">
                                Selengkapnya <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Tombol Navigasi -->
            <button class="carousel-nav prev" id="prevBerita">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="carousel-nav next" id="nextBerita">
                <i class="fas fa-chevron-right"></i>
            </button>
            <a href="<?= base_url('berita') ?>" class="btn btn-outline-dark rounded-pill px-4">Berita Selengkapnya <i class="fas fa-arrow-right"></i></a>
            <!-- Dots Indicator -->
            <div class="carousel-dots">
                <?php foreach ($berita_list as $index => $item): ?>
                <button class="dot <?= $index == 0 ? 'active' : '' ?>" data-index="<?= $index ?>"></button>
                <?php endforeach; ?>
            </div>
        </div>
        <?php else: ?>
        <div class="text-center py-5">
            <i class="fas fa-newspaper fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">Belum Ada Berita</h4>
            <p class="text-muted">Silakan admin menambahkan berita melalui dashboard admin.</p>
        </div>
        <?php endif; ?>
    </div>
</section>

  <!-- ORGANISASI KEMAHASISWAAN -->
  <section class="org-bg-orange">
    <div class="container-custom">
      <div class="org-layout">
        <div class="org-left">
          <h2 class="org-section-title">Daftar Organisasi<br>Kemahasiswaan<br>Universitas Telkom</h2>
          <p class="org-section-subtitle">Bergabung dan kembangkan potensimu bersama 25+ UKM favorit</p>
        </div>
        
        <div class="org-right">
          <div class="org-col-left">
            <div class="org-scroll-up-wrapper">
              <div class="org-scroll-up-content" id="orgLeftContent"></div>
            </div>
          </div>
          <div class="org-col-right">
            <div class="org-scroll-down-wrapper">
              <div class="org-scroll-down-content" id="orgRightContent"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- INTERNATIONAL RECOGNITIONS -->
  <section class="recognition-section">
    <div class="container-custom">
      <h2 class="recognition-title">International Recognitions</h2>
      <p class="recognition-subtitle">As a Research and Entrepreneurial University<br>Telkom University is well-known throughout the world</p>
      <div class="recognition-logos" id="recognitionLogosContainer">
        <!-- Logo akan di-generate oleh JavaScript -->
      </div>
    </div>
  </section>

  <!-- ALUMNI QUOTE -->
  <section class="alumni-quote-section">
    <div class="container-custom">
      <div class="alumni-quote-content">
        <div class="quote-icon"><i class="fas fa-quote-right"></i></div>
        <h2>Apa Kata Alumni</h2>
        <p>Jadilah salah satu orang hebat seperti mereka</p>
      </div>
    </div>
  </section>

  <!-- MITRA KERJASAMA -->
  <section class="partner-section">
    <div class="container-custom">
      <div class="partner-layout">
        <div class="partner-logos">
          <div class="partner-logos-grid" id="partnerLogosGrid"></div>
        </div>
        <div class="partner-content">
          <h2>MITRA KERJASAMA</h2>
          <p>Dalam penyelenggaraan pendidikan tinggi terbuka dan jarak jauh, TelU bekerjasama dengan berbagai pihak dalam berbagai hal, seperti penyediaan beasiswa, fasilitas penunjang dan tenaga ahli</p>
          <a href="#" class="btn-partner">Selengkapnya <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>
    </div>
  </section>

  <footer></footer>
</main>

<script>
  // ==================== DATA ORGANISASI (UKM) dengan logo dari folder assets ====================
  const organizations = [
    { name: "UKM Djawa Tjap Parabola", desc: "Bidang seni dan kebudayaan khususnya budaya Jawa.", logo: "assets/UKM Djawa Tjap Parabola.png", icon: "fas fa-mask" },
    { name: "UKM Aceh", desc: "UKM yang bergerak di bidang seni dan kebudayaan kedaerahan Aceh.", logo: "assets/UKM Aceh.png", icon: "fas fa-map-marker-alt" },
    { name: "UKM Tel-U Choir", desc: "UKM yang bergerak di bidang seni paduan suara.", logo: "assets/UKM Tel-U Choir.png", icon: "fas fa-music" },
    { name: "UKM Basket", desc: "UKM yang bergerak di bidang olahraga bola basket.", logo: "assets/UKM Basket.png", icon: "fas fa-basketball-ball" },
    { name: "UKM Bola", desc: "UKM yang bergerak di bidang olahraga sepak bola dan futsal.", logo: "assets/UKM Bola.png", icon: "fas fa-futbol" },
    { name: "UKM Karate-do", desc: "UKM yang bergerak di bidang seni bela diri karate.", logo: "assets/UKM Karate-do.png", icon: "fas fa-fist-raised" },
    { name: "UKM Merpati Putih", desc: "UKM yang bergerak di bidang seni bela diri pencak silat Merpati Putih.", logo: "assets/UKM Merpati Putih.png", icon: "fas fa-dove" },
    { name: "UKM Bengkel Seni Embun", desc: "Bidang seni dan kebudayaan tradisional maupun kontemporer.", logo: "assets/UKM Bengkel Seni Embun.png", icon: "fas fa-palette" }
  ];

  function splitArray(arr) {
    const mid = Math.ceil(arr.length / 2);
    return { left: arr.slice(0, mid), right: arr.slice(mid) };
  }

  function renderGrid(containerId, dataArray, isDuplicated = true) {
    const container = document.getElementById(containerId);
    if (!container) return;
    container.innerHTML = '';
    
    let itemsToRender = [...dataArray];
    if (isDuplicated) {
      itemsToRender = [...dataArray, ...dataArray];
    }
    
    const gridDiv = document.createElement('div');
    gridDiv.className = 'org-grid-one';
    
    itemsToRender.forEach((org) => {
      const card = document.createElement('div');
      card.className = 'org-card';
      
      const logoContent = `<img src="${org.logo}" alt="${org.name}" style="width:100%; height:100%; object-fit:cover;" onerror="this.parentElement.classList.add('no-image'); this.remove(); this.parentElement.innerHTML='<i class=\\'${org.icon}\\'></i>'">`;
      
      card.innerHTML = `
        <div class="org-logo">
          ${logoContent}
        </div>
        <div class="org-info">
          <h3>${org.name}</h3>
          <p>${org.desc}</p>
        </div>
      `;
      
      gridDiv.appendChild(card);
    });
    
    container.appendChild(gridDiv);
  }

  function renderOrganizations() {
    const { left, right } = splitArray(organizations);
    renderGrid('orgLeftContent', left, true);
    renderGrid('orgRightContent', right, true);
  }

  // ==================== DATA MITRA KERJASAMA ====================
  const partners = [
    { name: "Bank BRI", logo: "assets/Bank BRI.png", defaultIcon: "fas fa-university" },
    { name: "BPJS Kesehatan", logo: "assets/BPJS Kesehatan.png", defaultIcon: "fas fa-hospital-user" },
    { name: "Pertamina", logo: "assets/Pertamina.png", defaultIcon: "fas fa-gas-pump" },
    { name: "BRIN", logo: "assets/BRIN.png", defaultIcon: "fas fa-microscope" }
  ];

  function renderPartnerLogos() {
    const container = document.getElementById('partnerLogosGrid');
    if (!container) return;
    container.innerHTML = '';
    
    partners.forEach(partner => {
      const logoDiv = document.createElement('div');
      logoDiv.className = 'partner-logo-item';
      logoDiv.innerHTML = `<img src="${partner.logo}" alt="${partner.name}" style="max-width:100%; max-height:70px;" onerror="this.parentElement.innerHTML='<i class=\\'${partner.defaultIcon}\\' style=\\'font-size:2rem; color:#cbd5e1;\\'></i><div style=\\'font-size:0.7rem; margin-top:8px;\\'>${partner.name}</div>'">`;
      container.appendChild(logoDiv);
    });
  }

  // ==================== DATA INTERNATIONAL RECOGNITIONS (LOGO DARI ASSETS) ====================
  const recognitionItems = [
    { name: "Bank BRI", file: "assets/Bank BRI.png", fallback: "fas fa-chart-line" },
    { name: "Webometri", file: "assets/Webometrics.png", fallback: "fas fa-globe" },
    { name: "Times Higher Education", file: "assets/Times Higher Education.png", fallback: "fas fa-graduation-cap" },
    { name: "Green Metric", file: "assets/Green Metric.png", fallback: "fas fa-leaf" },
    { name: "AppliedHE", file: "assets/AppliedHE.png", fallback: "fas fa-chalkboard-user" },
    { name: "World University Rankings", file: "assets/World University Rankings.png", fallback:   "fas fa-trophy" }
  ];

  function renderRecognitionLogos() {
    const container = document.getElementById('recognitionLogosContainer');
    if (!container) return;
    container.innerHTML = '';
    
    recognitionItems.forEach(item => {
      const logoDiv = document.createElement('div');
      logoDiv.className = 'recognition-item';
      logoDiv.innerHTML = `
        <img src="${item.file}" alt="${item.name}" onerror="this.parentElement.innerHTML='<i class=\\'${item.fallback}\\' style=\\'font-size:2rem; color:#cbd5e1;\\'></i><span>${item.name}</span>'">
        <span>${item.name}</span>
      `;
      container.appendChild(logoDiv);
    });
  }

  // ==================== ANIMASI ANGKA ====================
  function animateNumber(element, finalValue, duration = 800) {
    if (!element) return;
    const finalNum = parseInt(finalValue.toString().replace(/,/g, '')) || 0;
    const startNum = 0;
    const startTime = performance.now();
    
    function updateNumber(currentTime) {
      const elapsed = currentTime - startTime;
      const progress = Math.min(elapsed / duration, 1);
      const easeOutCubic = 1 - Math.pow(1 - progress, 3);
      const currentValue = Math.floor(startNum + (finalNum - startNum) * easeOutCubic);
      element.textContent = currentValue.toLocaleString('id-ID');
      if (progress < 1) {
        requestAnimationFrame(updateNumber);
      } else {
        element.textContent = finalNum.toLocaleString('id-ID');
      }
    }
    requestAnimationFrame(updateNumber);
  }
  
  let animationTriggered = false;
  
  function checkAndAnimateNumbers() {
    if (animationTriggered) return;
    const achievementCard = document.getElementById('achievementCard');
    if (!achievementCard) return;
    const rect = achievementCard.getBoundingClientRect();
    const isVisible = rect.top < window.innerHeight - 100 && rect.bottom > 100;
    if (isVisible) {
      animationTriggered = true;
      animateNumber(document.getElementById('activeStudents'), 762918, 800);
      animateNumber(document.getElementById('countryCount'), 50, 600);
      animateNumber(document.getElementById('alumniCount'), 2156104, 900);
      animateNumber(document.getElementById('teluDaerah'), 39, 500);
      animateNumber(document.getElementById('teluLuar'), 1, 500);
    }
  }

  // ==================== DROPDOWN LAYANAN ====================
  function initDropdown() {
    const dropdownToggle = document.querySelector('.dropdown-toggle');
    const dropdownMenu = document.querySelector('.dropdown-menu-custom');
    
    if (dropdownToggle && dropdownMenu) {
      dropdownToggle.addEventListener('click', function(e) {
        if (window.innerWidth <= 768) {
          e.preventDefault();
          dropdownMenu.classList.toggle('show-mobile');
        }
      });
    }
  }

  // ==================== MOBILE TOGGLE ====================
  function initMobileToggle() {
    const mobileBtn = document.getElementById('mobileNavBtn');
    const navLinksDiv = document.getElementById('navLinks');
    if (mobileBtn) {
      mobileBtn.addEventListener('click', () => {
        navLinksDiv.classList.toggle('open');
      });
    }
    // Tutup jika klik link di mobile
    navLinksDiv && navLinksDiv.querySelectorAll('a:not(.dropdown-toggle)').forEach(link => {
      link.addEventListener('click', () => {
        if (window.innerWidth <= 768) {
          navLinksDiv.classList.remove('open');
        }
      });
    });
  }

  // ==================== NAVBAR SCROLL EFFECT ====================
  window.addEventListener('scroll', () => {
    const navbar = document.getElementById('navbar');
    if (!navbar) return;
    if (window.scrollY > 60) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  });

  // ==================== CAROUSEL NAVIGATION ====================
  function initCarouselNav() {
    // Di mobile, carousel adalah horizontal scroll - skip JS navigation
    if (window.innerWidth <= 768) return;

    const prevBtn = document.getElementById('prevBerita');
    const nextBtn = document.getElementById('nextBerita');
    if (prevBtn) {
      prevBtn.addEventListener('click', () => {
        activeNewsIdx = (activeNewsIdx - 1 + dummyBerita.length) % dummyBerita.length;
        updateCarouselPosition();
      });
    }
    if (nextBtn) {
      nextBtn.addEventListener('click', () => {
        activeNewsIdx = (activeNewsIdx + 1) % dummyBerita.length;
        updateCarouselPosition();
      });
    }
    
    let autoSlideInterval;
    function startAutoSlide() {
      if (autoSlideInterval) clearInterval(autoSlideInterval);
      autoSlideInterval = setInterval(() => {
        if (document.hasFocus()) {
          activeNewsIdx = (activeNewsIdx + 1) % dummyBerita.length;
          updateCarouselPosition();
        }
      }, 5000);
    }
    function stopAutoSlide() {
      if (autoSlideInterval) {
        clearInterval(autoSlideInterval);
        autoSlideInterval = null;
      }
    }
    const container = document.querySelector('.berita-carousel-container');
    if (container) {
      container.addEventListener('mouseenter', stopAutoSlide);
      container.addEventListener('mouseleave', startAutoSlide);
    }
    startAutoSlide();
  }

  // ==================== INITIALIZATION ====================
  document.addEventListener('DOMContentLoaded', function() {
    renderOrganizations();
    renderPartnerLogos();
    renderRecognitionLogos();
    initDropdown();
    initMobileToggle();
    
    window.addEventListener('scroll', checkAndAnimateNumbers);
    setTimeout(checkAndAnimateNumbers, 500);
  });
  // ==================== BERITA CAROUSEL ====================
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.berita-card');
    const dots = document.querySelectorAll('.dot');
    const prevBtn = document.getElementById('prevBerita');
    const nextBtn = document.getElementById('nextBerita');
    
    if (!cards.length) return;
    
    let currentIndex = 0;
    const totalCards = cards.length;
    
    // Fungsi update posisi card
    function updateCarousel() {
        cards.forEach((card, index) => {
            card.classList.remove('active', 'left', 'right', 'left-far', 'right-far');
            
            let position = index - currentIndex;
            
            if (position < -1) position = -2;
            if (position > 1) position = 2;
            
            if (index === currentIndex) {
                card.classList.add('active');
            } else if (position === -1 || (currentIndex === 0 && index === totalCards - 1)) {
                card.classList.add('left');
            } else if (position === 1 || (currentIndex === totalCards - 1 && index === 0)) {
                card.classList.add('right');
            } else if (position === -2) {
                card.classList.add('left-far');
            } else if (position === 2) {
                card.classList.add('right-far');
            }
        });
        
        // Update active dot
        dots.forEach((dot, idx) => {
            dot.classList.toggle('active', idx === currentIndex);
        });
    }
    
    // Navigasi ke berita sebelumnya
    function prevBerita() {
        currentIndex = (currentIndex - 1 + totalCards) % totalCards;
        updateCarousel();
    }
    
    // Navigasi ke berita selanjutnya
    function nextBerita() {
        currentIndex = (currentIndex + 1) % totalCards;
        updateCarousel();
    }
    
    // Event listeners untuk tombol
    if (prevBtn) prevBtn.addEventListener('click', prevBerita);
    if (nextBtn) nextBtn.addEventListener('click', nextBerita);
    
    // Event listeners untuk dots
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentIndex = index;
            updateCarousel();
        });
    });
    
    // Ketika card diklik, arahkan ke detail berita
    cards.forEach((card) => {
        const slug = card.dataset.slug;
        const readmoreLink = card.querySelector('.berita-readmore');
        
        card.addEventListener('click', (e) => {
            // Jangan trigger jika klik pada link (sudah akan redirect sendiri)
            if (e.target.closest('.berita-readmore')) {
                return;
            }
            
            // Jika card yang diklik bukan card tengah, pindahkan ke tengah dulu
            if (!card.classList.contains('active')) {
                const index = parseInt(card.dataset.index);
                if (!isNaN(index)) {
                    currentIndex = index;
                    updateCarousel();
                }
            } else {
                // Jika sudah di tengah, redirect ke detail
                if (slug) {
                    window.location.href = "<?= base_url('berita/detail/') ?>" + slug;
                }
            }
        });
    });
    
    // Auto slide setiap 5 detik
    let autoSlideInterval;
    
    function startAutoSlide() {
        if (autoSlideInterval) clearInterval(autoSlideInterval);
        autoSlideInterval = setInterval(() => {
            if (document.hasFocus()) {
                nextBerita();
            }
        }, 5000);
    }
    
    function stopAutoSlide() {
        if (autoSlideInterval) {
            clearInterval(autoSlideInterval);
            autoSlideInterval = null;
        }
    }
    
    const container = document.querySelector('.berita-carousel-container');
    if (container) {
        container.addEventListener('mouseenter', stopAutoSlide);
        container.addEventListener('mouseleave', startAutoSlide);
    }
    
    startAutoSlide();
    updateCarousel();
});
</script>

</body>
</html>