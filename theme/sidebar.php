<nav class="mt-2">

 <!-- JUSTIN SOLUTIONS - JUSTIN 2025  -->

        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

           <li class="nav-header">
            <a href='<?php echo WEB_ROOT; ?>' class="nav-link <?php  echo ($title=='Home') ? "active" : 'na' ;?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                   </p>
            </a>
          </li>

 <li class="nav-item">
  <a href='<?php echo WEB_ROOT; ?>module/details' class="nav-link <?php  echo ($title=='Details Module') ? "active" : 'na' ;?>">
  <i class="nav-icon fa fa-info-circle"></i>
  <p style="font-weight: normal">
                Details
  </p>
  </a>
  </li>

  <li class="nav-item">
  <a href='<?php echo WEB_ROOT; ?>module/student' class="nav-link <?php  echo ($title=='Student Module') ? "active" : 'na' ;?>">
  <i class="nav-icon fa fa-user-graduate"></i>
  <p style="font-weight: normal">
                Student
  </p>
  </a>
  </li>

  <li class="nav-item">
  <a href='<?php echo WEB_ROOT; ?>module/course' class="nav-link <?php  echo ($title=='Course Module') ? "active" : 'na' ;?>">
  <i class="nav-icon fa fa-book"></i>
  <p style="font-weight: normal">
                Course
  </p>
  </a>
  </li>

   <li class="nav-item">
  <a href='<?php echo WEB_ROOT; ?>module/Subject' class="nav-link <?php  echo ($title=='Subject Module') ? "active" : 'na' ;?>">
  <i class="nav-icon fa fa-book-open"></i>
  <p style="font-weight: normal">
                Subject
  </p>
  </a>
  </li>

    <li class="nav-item">
  <a href='<?php echo WEB_ROOT; ?>module/schoolyear' class="nav-link <?php  echo ($title=='School Year Module') ? "active" : 'na' ;?>">
  <i class="nav-icon fa fa-calendar-alt"></i>
  <p style="font-weight: normal">
                School Year
  </p>
  </a>
  </li>

    <li class="nav-item">
  <a href='<?php echo WEB_ROOT; ?>module/section' class="nav-link <?php  echo ($title=='Section Module') ? "active" : 'na' ;?>">
  <i class="nav-icon fa fa-chalkboard"></i>
  <p style="font-weight: normal">
                Section
  </p>
  </a>
  </li>

     <li class="nav-item">
  <a href='<?php echo WEB_ROOT; ?>module/enrollment' class="nav-link <?php  echo ($title=='Enrollment Module') ? "active" : 'na' ;?>">
  <i class="nav-icon fa fa-clipboard-list"></i>
  <p style="font-weight: normal">
                Enrollment
  </p>
  </a>
  </li>

      <li class="nav-item">
  <a href='<?php echo WEB_ROOT; ?>module/enrollmentdetails' class="nav-link <?php  echo ($title=='Enrollment Details Module') ? "active" : 'na' ;?>">
  <i class="nav-icon fa fa-list-alt"></i>
  <p style="font-weight: normal">
                Enrollment Details
  </p>
  </a>
  </li>

      <li class="nav-item">
  <a href='<?php echo WEB_ROOT; ?>module/grades' class="nav-link <?php  echo ($title=='Grades Module') ? "active" : 'na' ;?>">
  <i class="nav-icon fa fa-clipboard-check"></i>
  <p style="font-weight: normal">
                Grades
  </p>
  </a>
  </li>

          <li class="nav-item has-treeview">

            <a href="#" class="nav-link <?php  echo ($title=='User Module' || $title=='User Type' ) ? "active" : 'na' ;?>">
              <i class="fas fa-cog"></i>
              <p>
                Account Settings
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href='<?php echo WEB_ROOT; ?>module/user/' class="nav-link">
                  <i class="nav-icon fa fa-users"></i>
                  <p>Manage User Accounts</p>
                </a>
              </li>
              <li class="nav-item">
                <a href='<?php echo WEB_ROOT; ?>module/usertype/' class="nav-link">
                  <i class="nav-icon fa fa-key"></i>
                  <p>Manage User Type</p>
                </a>
              </li>
            </ul>
          </li>



            </ul>




        </ul>
      </nav>