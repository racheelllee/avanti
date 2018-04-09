<table class="body-wrap">
    <tr>
        <td></td>
        <td class="container" width="600">
            <div class="content">
                <table class="main" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="content-wrap">
                            <table  cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="background-color:#4b4e52;">
                                    	<center>
                                        	<img src="/images/logo_1.png">
                                        </center>
                                        <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block">
                                        <h3><?= __('Request to Reset Your Password');?></h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block">

                                        Welcome <?php echo $nombre; ?>,<br/><br/> You have requested to have your password reset on. Please click the link below to reset your password now: <br><br>
                                        <a href="<?php echo $this->Url->build($link, true); ?>"><?php echo $this->Url->build($link, true); ?></a><br><br>
                                        If clicking on the link doesn\'t work, try copying and pasting it into your browser.<br/><br/>Thanks,<br>
                                        <?= SITE_NAME ?>
                                    </td>
                                </tr>                                
                                
                                <tr>
                                    <td class="content-block aligncenter">
                                        &nbsp;
                                    </td>
                                </tr>
                              </table>
                        </td>
                    </tr>
                </table>
                <div class="footer">
                    <table width="100%">
                        <tr>
                            <td class="aligncenter content-block">Saludos de parte del equipo de <?= SITE_NAME ?> </td>
                        </tr>
                        <tr>
                            <td class="aligncenter content-block"><?= EMAIL_FROM_ADDRESS ?></td>
                        </tr>
                        <tr>
                            <td class="aligncenter content-block"><!-- 52 (81) 83571978 --></td>
                        </tr>
                    </table>
                </div></div>
        </td>
        <td></td>
    </tr>
</table>