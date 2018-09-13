<?php 
   $args = array('sort_order' => 'asc'); 
   $pages = get_pages($args); 
   $error['theme1slug'] = 1;
   $error['theme2slug'] = 1;
   $result = 2;
   
   if(isset($_POST['zt_submit'])){
		$theme1_slug = $_POST['theme1_slug'];
		$theme1_home_page = $_POST['theme1_home_page'];
		$theme2_slug = $_POST['theme2_slug'];
		$theme2_home_page = $_POST['theme2_home_page'];
		
		update_option( 'zt_theme1_home_page', $theme1_home_page );
		update_option( 'zt_theme2_home_page', $theme2_home_page );
		
		if(theme_exists($theme1_slug) == false){
			$error['theme1slug'] = 0;
		}else{
			$error['theme1slug'] = 1;
			update_option( 'zt_theme1_slug', $theme1_slug );
		}
		
		if(theme_exists($theme2_slug) == false){
			$error['theme2slug'] = 0;
		}else{
			$error['theme2slug'] = 1;
			update_option( 'zt_theme2_slug', $theme2_slug );
		}
		
		if($error['theme1slug'] == 0|| $error['theme2slug'] == 0){
			$result = 0;
		}else{
			$result = 1;
		}
   }  
   
   
   function theme_exists($themename){
		$theme = wp_get_theme( $themename);
		if ( $theme->exists() ){
			return true;
		}else{
			return false;
		}
   }
   
   ?>
<div class="wrap">
   <h1>HomePage Settings</h1>
   <?php if($result == 1){ ?>
   <div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible">
      <p><strong>Settings saved!</strong></p>
      <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
   </div>
   <?php } elseif($result == 0) {?>
   <div id="setting-error-settings_updated" class="error settings-error notice is-dismissible">
      <p><strong>Error!</strong></p>
      <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
   </div>
   <?php } else {} ?>
   <form method="post" action="">
      <table class="form-table">
         <tr>
            <th scope="row"><label for="theme1_slug">Theme 1 Slug</label></th>
            <td>
               <input name="theme1_slug" type="text" id="theme1_slug" value="<?php if(isset($_POST['theme1_slug'])){ echo $_POST['theme1_slug'] ;}else{ echo get_option( 'zt_theme1_slug');}?>" class="regular-text" aria-describedby="theme1-slug-description" required>
               <p class="description" id="theme1-slug-description">Enter theme 1 slug.</p>
               <?php if($error['theme1slug'] == 0){ echo "<p class='description' style='color:red;'>Please enter valid theme slug.</p>";}?>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="theme1_home_page">Home Page for Theme 1 </label></th>
            <td>
               <select  name="theme1_home_page" id="theme1_home_page" aria-describedby="theme1-home-page-description" required>
			   <option value=''>---</option>
               <?php foreach($pages as $key => $value){
                  if($value->ID == get_option( 'zt_theme1_home_page')){ $option = "selected";}else { $option = "";}
                             echo "<option value='$value->ID' $option  >$value->post_title</option>"; 
                             }?>
               </select>
               <p class="description" id="theme1-home-page-description">Select the page name which needs to be set <strong>Home Page</strong> on Theme 1 activation.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="theme2_slug">Theme 2 Slug</label></th>
            <td>
               <input name="theme2_slug" type="text" id="theme2_slug"  value="<?php if(isset($_POST['theme2_slug'])){ echo $_POST['theme2_slug'] ;}else{ echo get_option( 'zt_theme2_slug');}?>" class="regular-text" aria-describedby="theme2-slug-description" required>
               <p class="description" id="theme2-slug-description">Enter theme 2 slug.</p>
               <?php if($error['theme2slug'] == 0){ echo "<p class='description' style='color:red;'>Please enter valid theme slug.</p>";}?>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="theme2_home_page">Home Page for Theme 2 </label></th>
            <td>
               <select  name="theme2_home_page" id="theme2_home_page" aria-describedby="theme2-home-page-description" required	>
			   <option value=''>---</option>
               <?php foreach($pages as $key => $value){
                  if($value->ID == get_option( 'zt_theme2_home_page')){ $option = "selected";}else { $option = "";}	
                              echo "<option value='$value->ID' $option>$value->post_title</option>"; 
                              }?>
               </select>
               <p class="description" id="theme2-home-page-description">Select the page name which needs to be set <strong>Home Page</strong> on Theme 2 activation.</p>
            </td>
         </tr>
      </table>
      <p class="submit"><input type="submit" name="zt_submit" id="submit" class="button button-primary" value="Save Changes"></p>
   </form>
   <?php if(get_option( 'zt_theme1_home_page')!= false && get_option( 'zt_theme2_home_page')!= false){ ?>
	<?php if(get_post_status ( get_option( 'zt_theme1_home_page')) == "trash" || get_post_status ( get_option( 'zt_theme1_home_page')) == ""){ ?>
    <p class="description" style="color:red;">*The previously set homepage(<strong><?php echo get_the_title(get_option( 'zt_theme1_home_page'));?></strong>) for the "<strong><?php echo wp_get_theme(get_option( 'zt_theme1_slug'));?></strong>" theme does not exists.</p>	
	<?php } if(get_post_status ( get_option( 'zt_theme2_home_page')) == "trash" || get_post_status ( get_option( 'zt_theme2_home_page')) == "") { ?>
    <p class="description" style="color:red;">*The previously set homepage(<strong><?php echo get_the_title(get_option( 'zt_theme2_home_page'));?></strong>) for the "<strong><?php echo wp_get_theme(get_option( 'zt_theme2_slug'));?></strong>" theme does not exists.</p>	
	<?php } ?>
	<?php } ?>
</div>
<hr>
<h2 class="title">Menu</h2>
<div>
   <p>Replace the default menu with the below function when menu is mapped to <strong> V1 Primary Menu</strong>.</p>
   <code>wp_nav_menu( array('theme_location' => 'v1-primary-menu','menu_class' => 'primary-menu',) );</code>
   <p>Replace the default menu with the below function when menu is mapped to <strong> V2 Primary Menu</strong>.</p>
   <code>wp_nav_menu( array('theme_location' => 'v2-primary-menu','menu_class' => 'primary-menu',) ); </code>	
</div>