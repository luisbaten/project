   <?php
    error_reporting(0);
    ?>
   <main>
     
     <header class="stick">
       <div class="topbar">
         <div class="container">
           <div class="topbar-register">
             <?php if (strlen($_SESSION['fosuid'] == 0)) { ?>
               <a class="log-popup-btn" href="#" title="Iniciar" itemprop="url">INICIAR SESION</a> / <a class="sign-popup-btn" href="#" title="Registro" itemprop="url">REGISTRARSE</a>
             <?php } ?>
             <?php if (strlen($_SESSION['fosuid'] > 0)) { ?>
               / <a href="logout.php" title="Mi Cuenta" itemprop="url">Cerrar Sesión</a>
             <?php } ?>
           </div>
         </div>
       </div><!-- Topbar -->
       <div class="logo-menu-sec">
         <div class="container">
           <div class="logo">
             <a href="index.php" title="Inicio" itemprop="url">
               <img src="assets/img/ong_1.jpeg" alt="ONG" itemprop="image" style="width: 70px; ">
               <img src="assets/img/umg.jpg" alt="ONG" itemprop="image" style="width: 70px; ">
             </a>
           </div>
           <nav>
             <div class="menu-sec">
               <ul>
                 <li><a href="index.php" title="Home" itemprop="url">Inicio</li>
                 <li><a href="our-menu.php" title="Contacto" itemprop="url">Proyectos </a></li>
                 <li><a class="btn btn-success" href="form.php" title="Contacto" itemprop="url">Solicitar proyectos </a></li>
                 <li><a class="btn btn-primary" href="/project/admin/" title="Contacto" itemprop="url">Iniciar sesión en admin </a></li>
               </ul>
               <?php if (strlen($_SESSION['fosuid'] == 0)) { ?>
                 <a class="log-popup-btn red-bg brd-rd4" href="#" title="Iniciar" itemprop="url">Iniciar Sesión</a>
               <?php } ?>
               <?php if (strlen($_SESSION['fosuid'] > 0)) { ?>
                 <a class="red-bg brd-rd4" href="logout.php" title="Carrito" itemprop="url"> <i class="fa fa-delete"></i> &nbsp;</span>Cerrar Sesion</a>
               <?php } ?>
             </div>
           </nav><!-- Navigation -->
         </div>
       </div><!-- Logo Menu Section -->
     </header><!-- Header -->
    </main>

    