<?php
if(!defined('THEMEAXE')){
	exit('What are you doing here??');
}

$axethemesettings = themeaxe_GetAllThemeSettings();

list($res,$msg) = themeaxe_updateoptions();

$listAxeSettingsMenuItems = themeaxe_Settings_MenuItems();

$listAxeSettingsBlocks = themeaxe_Settings_BlocksFunctions();

$activetab = themeaxe_getSettingsActiveTabIs();
?>
<div class="width98p">
	<div class="axethemeadminwrapper">
		<h1 class="axethemeheading"><?php echo THEMEAXE . ' ' . __('Settings', 'light-axe'); ?></h1>
		<?php if($res !== null){
			$mcls = 'updated';
			if($res === false){
				$mcls = 'error';
			}
			?>
			<div class="<?php echo $mcls;?> fade"><p><?php echo $msg; ?></p></div>
			<?php } ?>
			<div id="poststuff">
				<div id="post-body" class="metabox-holder columns-2">
					<div id="post-body-content" class="axesettingsblocks">

						<form method="post" action="" enctype="multipart/form-data" class="axeform axeform-4" id="post">
							<div id="postbox-container-11" class="postbox-container axeleftcol axecols">
								<div id="side-sortables" class="meta-box-sortables ui-sortable">
									<div id="axevendorsubmit" class="postbox ">
										<div class="handlediv" title="Click to toggle"><br></div><h3 class="hndle"><span><?php _e('Settings Menu', 'light-axe'); ?></span></h3>
										<div class="inside">
											<ul>
												<?php
												foreach($listAxeSettingsMenuItems as $mik => $mival){
													$activemiclass = $activetab == $mik ? 'activeaxethemetoggler' : '';
													$miurl = admin_url( 'admin.php?page=light-axe&tab='.$mik.'#'.$mik);
													?>
													<li class="axethemetoggler <?php echo $activemiclass; ?>" data="<?php echo $mik; ?>"><a href="<?php echo $miurl; ?>"><?php echo $mival; ?></a></li>
													<?php
												}
												?>
											</ul>
										</div>

									</div>


								</div>
							</div>
							<div id="postbox-container-2" class="postbox-container axecols">
								<div id="axevendorsubmit" class="postbox ">
									<div class="handlediv" title="Click to toggle"><br></div><h3 class="hndle"><span><?php _e('Update Settings', 'light-axe'); ?></span></h3>
									<div class="inside">
										<input type="submit" name="publish" id="publish" class="button button-primary button-large" value="Update Now !" accesskey="p">
										<input type="hidden" name="themeaxe_update_opts" value="1" />
										<input type="hidden" name="activetabis" id="activetabis" value="<?php echo $activetab; ?>" />
									</div>

								</div>

								<div id="themeimgpreview" style="position:relative;"></div>
								<?php
								foreach($listAxeSettingsBlocks as $sbk => $sbval){
									$sblabel = isset($listAxeSettingsMenuItems[$sbk]) ? $listAxeSettingsMenuItems[$sbk] .' ' . __('Settings', 'light-axe') : strtoupper($sbk);
									$activesbclass = $activetab == $sbk ? 'activeaxethemetoggle' : '';
									?>
									<div id="<?php echo $sbk; ?>" class="postbox axethemetoggle <?php echo $activesbclass;?>"><!-- <?php echo $sblabel; ?> Starts -->
										<div class="handlediv" title="Click to toggle"><br></div><h3 class="hndle"><span><?php echo $sblabel; ?></span></h3>
										<div class="inside">
											<?php
											if(function_exists($sbval)){
												call_user_func($sbval, $axethemesettings);
											}
											?>
										</div>

									</div><!-- <?php echo $sblabel; ?> Ends -->
									<?php
								}
								?>

								<div id="axevendorsubmit" class="postbox ">
									<div class="handlediv" title="Click to toggle"><br></div><h3 class="hndle"><span><?php _e('Update Settings', 'light-axe'); ?></span></h3>
									<div class="inside">
										<input type="submit" name="publish" id="publish" class="button button-primary button-large" value="<?php _e('Update Now !', 'light-axe');?>" accesskey="p">
										<input type="hidden" name="themeaxe_update_opts" value="1" />
									</div>

								</div>
							</div>


						</form>
					</div>
				</div>
			</div>
		</div>
	</div>