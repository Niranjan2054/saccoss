 <?php 
    if (getFileName()=='index' || getFileName()=='reset-password') {
      ?>
        </body>
      </html>
      <?php
    }else{
      ?>
      <!-- footer content -->
        <footer>
          <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    
    <!-- jQuery -->
    <script src="<?php echo JS_PATH; ?>bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo JS_PATH; ?>fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo JS_PATH; ?>nprogress.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?php echo JS_PATH; ?>custom.min.js"></script>
  </body>
</html>

      <?php
    }
  ?>