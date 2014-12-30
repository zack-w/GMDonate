<h3 style="margin-left: 20px;">General Settings</h3>

<div class="panel-body">
	<form method="POST" action="?page=admin&area=general_settings" enctype="multipart/form-data">
		<input type="hidden" name="settings_updated" value="1" />
		
		<?php
			foreach( Setting::GetCachedResults( "Setting" ) as $SettingObj ) {
				$EditText = $SettingObj->GenerateEditor();
				
				if( $EditText !== false )
					echo $EditText;
			}
		?>
	
		<div class="col-sm-6 col-md-4" style="text-align: right;line-height: 34px;">
			<input type="submit" class="btn btn-primary" style="margin-left: 30px;" value="Save" />
		</div>
	</form>
</div>

<br />
<h3 style="margin-left: 20px;">Homepage Editor</h3>

<div style='background-color: #FFF;padding: 0px 28px 20px 28px;'>
	<div class="btn-toolbar" data-role="editor-toolbar" data-target="#homeWYSIWYG" style="margin-left: 20px;">
		<div class="btn-group">
			<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="Font"><i class="icon-font"></i><b class="caret"></b></a>
			<ul class="dropdown-menu">
          <li><a data-edit="fontName Serif" style="font-family:'Serif'">Serif</a></li><li><a data-edit="fontName Sans" style="font-family:'Sans'">Sans</a></li><li><a data-edit="fontName Arial" style="font-family:'Arial'">Arial</a></li><li><a data-edit="fontName Arial Black" style="font-family:'Arial Black'">Arial Black</a></li><li><a data-edit="fontName Courier" style="font-family:'Courier'">Courier</a></li><li><a data-edit="fontName Courier New" style="font-family:'Courier New'">Courier New</a></li><li><a data-edit="fontName Comic Sans MS" style="font-family:'Comic Sans MS'">Comic Sans MS</a></li><li><a data-edit="fontName Helvetica" style="font-family:'Helvetica'">Helvetica</a></li><li><a data-edit="fontName Impact" style="font-family:'Impact'">Impact</a></li><li><a data-edit="fontName Lucida Grande" style="font-family:'Lucida Grande'">Lucida Grande</a></li><li><a data-edit="fontName Lucida Sans" style="font-family:'Lucida Sans'">Lucida Sans</a></li><li><a data-edit="fontName Tahoma" style="font-family:'Tahoma'">Tahoma</a></li><li><a data-edit="fontName Times" style="font-family:'Times'">Times</a></li><li><a data-edit="fontName Times New Roman" style="font-family:'Times New Roman'">Times New Roman</a></li><li><a data-edit="fontName Verdana" style="font-family:'Verdana'">Verdana</a></li></ul>
		</div>
			
		<div class="btn-group">
			<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="icon-text-height"></i>&nbsp;<b class="caret"></b></a>
				<ul class="dropdown-menu">
				<li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
				<li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
				<li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
				</ul>
		</div>
		<div class="btn-group">
			<a class="btn btn-default" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="icon-bold"></i></a>
			<a class="btn btn-default" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="icon-italic"></i></a>
			<a class="btn btn-default" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="icon-underline"></i></a>
		</div>
		<div class="btn-group">
			<a class="btn btn-default" data-edit="insertunorderedlist" title="Bullet list"><i class="icon-list-ul"></i></a>
			<a class="btn btn-default" data-edit="insertorderedlist" title="Number list"><i class="icon-list-ol"></i></a>
		</div>
		<div class="btn-group">
			<a class="btn btn-default" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="icon-align-left"></i></a>
			<a class="btn btn-default" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="icon-align-center"></i></a>
			<a class="btn btn-default" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="icon-align-right"></i></a>
		</div>
		<div class="btn-group">
		<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="icon-link"></i></a>
			<div class="dropdown-menu input-append">
			    <input class="span2" placeholder="URL" type="text" data-edit="createLink">
			    <button class="btn btn-default" type="button">Add</button>
			</div>
			<a class="btn btn-default" data-edit="unlink" title="Remove Hyperlink"><i class="icon-cut"></i></a>

		</div>
		
		<div class="btn-group">
			<a class="btn btn-default" title="" id="pictureBtn" data-original-title="Insert picture (or just drag &amp; drop)"><i class="icon-picture"></i></a>
			<input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" style="opacity: 0; position: absolute; top: 0px; left: 0px; width: 37px; height: 30px;">
		</div>
		<div class="btn-group">
			<a class="btn btn-default" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="icon-undo"></i></a>
			<a class="btn btn-default" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="icon-repeat"></i></a>
		</div>
	</div>
	
	<div id="homeWYSIWYG" class="homeWYSIWYG" onkeyup="homeFormUpdated();" onkeypress="homeFormUpdated();">
		<?php
			$HomeSetting = Setting::GetByField( "Setting", "SysName", "homehtml" );
			echo $HomeSetting->GetValue();
		?>
	</div>
	
	<form id="updateHomeForm"  method="POST" action="?page=admin&area=general_settings">
		<input type="hidden" name="settings_updated" value="1" />
		<input type="hidden" id="input_homehtml" name="input_homehtml" value="<?= $HomeSetting->GetValue(); ?>" />
		<input type="submit" name="go" class="btn btn-primary" style="margin-left: 30px;" value="Save" />
	</form>
</div>

<script>
	$('#homeWYSIWYG').wysiwyg();
	
	function homeFormUpdated() {
		document.getElementById( "input_homehtml" ).value = $('.homeWYSIWYG').cleanHtml();
	}
</script>

