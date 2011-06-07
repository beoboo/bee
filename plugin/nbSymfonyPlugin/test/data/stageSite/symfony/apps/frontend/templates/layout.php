<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body>
    <div id="page">
      <?php include_partial('main/header') ?>
      <div id="center">
        <div id="content" class="container_12 clearfix">
          <div id="left-content" class="grid_8">
            <?php echo $sf_content ?>
          </div>
          <div id="right-content" class="grid_4">
            <?php include_partial('deal/otherDeals') ?>
            <?php include_partial('newsletter/subscribe') ?>
          </div>
        </div>
      </div>
      <?php include_partial('main/footer') ?>
    </div>
  </body>
</html>