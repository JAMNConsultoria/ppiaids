<?php set_include_path(get_include_path().PATH_SEPARATOR.'../'); ?>
<?php include 'incs/cabecalho.php'; ?>
<div id="wrapper">

<div id="menu"><br />
	<?php include 'incs/menu.php'; ?>
</div>
<div id="divsintese" style="z-index: 9; position: absolute;background-color:#FFF; border:1px solid #bdbdbd;float: right;margin-top: 10px"></div>
<div id="conteudo">
    
    <p class="tit"><?php echo htmlentities("Localiza Município");?></p>
	<script type="text/javascript" src="mapa/swfobject.js"></script>
    <script type="text/javascript">
        var swfVersionStr = "10.0.0";
        var xiSwfUrlStr = "mapa/playerProductInstall.swf";
        var flashvars = {};
        var params = {};
        params.quality = "high";
        params.bgcolor = "#ffffff";
        params.allowscriptaccess = "sameDomain";
        params.allowfullscreen = "true";
        params.wmode="transparent";
        var attributes = {};
        attributes.id = "ppiaids_map";
        attributes.name = "ppiaids_map";
        attributes.align = "middle";
        swfobject.embedSWF(
            "mapa/ppiaids_map.swf", "flashContent", 
            "500px", "516px", 
            swfVersionStr, xiSwfUrlStr, 
            flashvars, params, attributes);
        swfobject.createCSS("#flashContent", "display:block;text-align:left;");
    </script>
    <div id="flashContent">
        <p>
            To view this page ensure that Adobe Flash Player version 
            10.0.0 or greater is installed. 
        </p>
        <script type="text/javascript"> 
            var pageHost = ((document.location.protocol == "https:") ? "https://" :	"http://"); 
            document.write("<a href='http://www.adobe.com/go/getflashplayer'><img src='" 
                            + pageHost + "www.adobe.com/images/shared/download_buttons/get_flash_player.gif' alt='Get Adobe Flash player' /></a>" ); 
        </script> 
    </div>
        <div id="flash" style="z-index: 0; position: relative">
    <noscript>
        <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="500px" height="516px" id="ppiaids_map">
            <param name="movie" value="mapa/ppiaids_map.swf" />
            <param name="quality" value="high" />
            <param name="bgcolor" value="#ffffff" />
            <param name="allowScriptAccess" value="sameDomain" />
            <param name="wmode" value="transparent" />
            <param name="allowFullScreen" value="true" />
            <!--[if !IE]>-->
            <object type="application/x-shockwave-flash" data="mapa/ppiaids_map.swf" width="500px" height="516px">
                <param name="quality" value="high" />
                <param name="bgcolor" value="#ffffff" />
                <param name="allowScriptAccess" value="sameDomain" />
                <param name="allowFullScreen" value="true" />
                <param name="wmode" value="transparent" />
            <!--<![endif]-->
            <!--[if gte IE 6]>-->
                <p> 
                    Either scripts and active content are not permitted to run or Adobe Flash Player version
                    10.0.0 or greater is not installed.
                </p>
            <!--<![endif]-->
                <a href="http://www.adobe.com/go/getflashplayer">
                    <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash Player" />
                </a>
            <!--[if !IE]>-->
            </object>
            <!--<![endif]-->            
        </object>
    </noscript>
            </div>        
</div>
<br />
</div>
<?php include 'incs/rodape.php'; ?> 