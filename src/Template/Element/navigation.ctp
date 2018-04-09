<?php
    use Cake\Utility\Inflector;
    $actionUrl      = Inflector::camelize($this->request['controller']).'/'.$this->request['action'];
    $activeClass    = 'active open';
    $inactiveClass  = '';
    $usuario        = $this->UserAuth->getUser();
    $class          = '';

    // $sections = [
    //     'Users'         => ['action' => 'index', 'plugin' => 'Usermgmt']
    // ];

    if($this->UserAuth->isLogged()) {

        // foreach ($sections as $section => $config) {
        //     if ($this->UserAuth->HP($section, $config['action'], $config['plugin'])) {
        //         $class = $actionUrl == "{$section}/{$config['action']}" ? $activeClass : $inactiveClass;
        //         $href = $this->Html->link(__($section), [
        //             'controller'=>$section, 
        //             'action'=>$config['action'], 
        //             'plugin'=>$config['plugin']
        //         ]);
        //         echo "<li class='nav-item $class'>$href</li>";
        //     }
        // } 

        if($this->UserAuth->HP('Users', 'index', 'Usermgmt')) {


            $open = (  in_array( $actionUrl , [ 'Users/addUser','Users/index']  )   ) ? '<span class="selected"></span>' : $inactiveClass;

            echo "<li class='nav-item ".(( in_array( $actionUrl , [ 'Users/addUser','Users/index']  ) ) ? $activeClass : $inactiveClass)."'>";

                 echo '<a href="#" class="nav-link nav-toggle" class="nav-link nav-toggle"> <i class="fa  fa-users"></i> <span class="nav-label">'.__('Users').'</span>  '.$open.'  <span class="fa arrow '.(( in_array( $actionUrl , [ 'Users/addUser','Users/index']  ) ) ? "open" : $inactiveClass).'"></span> </a>';


                echo "<ul class='sub-menu'>";
                    if($this->UserAuth->HP('Users', 'addUser', 'Usermgmt')) {
                        echo "<li class='nav-item ".(($actionUrl=='Users/addUser') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('Agregar Usuario'), ['controller'=>'Users', 'action'=>'addUser', 'plugin'=>'Usermgmt'])."</li>";
                    }
                    if($this->UserAuth->HP('Users', 'index', 'Usermgmt')) {
                        echo "<li class='nav-item ".(($actionUrl=='Users/index') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('Listado de Usuarios'), ['controller'=>'Users', 'action'=>'index', 'plugin'=>'Usermgmt'])."</li>";
                    }
                echo "</ul>";
            echo "</li>";

        }

        if($this->UserAuth->HP('Productos', 'index', false)) {


            $open = (  in_array( $actionUrl , [ 'productos/add','productos/index']  )   ) ? '<span class="selected"></span>' : $inactiveClass;

            echo "<li class='nav-item ".(( in_array( $actionUrl , [ 'productos/add','productos/index']  ) ) ? $activeClass : $inactiveClass)."'>";

                 echo '<a href="#" class="nav-link nav-toggle" class="nav-link nav-toggle"> <i class="fa  fa-users"></i> <span class="nav-label">'.__('Productos').'</span>  '.$open.'  <span class="fa arrow '.(( in_array( $actionUrl , [ 'productos/add','productos/index']  ) ) ? "open" : $inactiveClass).'"></span> </a>';


                echo "<ul class='sub-menu'>";
                    if($this->UserAuth->HP('Productos', 'add', false)) {
                        echo "<li class='nav-item ".(($actionUrl=='productos/add') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('Agregar Producto'), ['controller'=>'Productos', 'action'=>'add', 'plugin'=>false])."</li>";
                    }
                    if($this->UserAuth->HP('Productos', 'index', false)) {
                        echo "<li class='nav-item ".(($actionUrl=='productos/index') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('Listado de Productos'), ['controller'=>'Productos', 'action'=>'index', 'plugin'=>false])."</li>";
                    }
                echo "</ul>";
            echo "</li>";

        }

        if($this->UserAuth->HP('Categorias', 'index', false)) {


            $open = (  in_array( $actionUrl , [ 'categorias/add','categorias/index']  )   ) ? '<span class="selected"></span>' : $inactiveClass;

            echo "<li class='nav-item ".(( in_array( $actionUrl , [ 'categorias/add','categorias/index']  ) ) ? $activeClass : $inactiveClass)."'>";

                 echo '<a href="#" class="nav-link nav-toggle" class="nav-link nav-toggle"> <i class="fa  fa-users"></i> <span class="nav-label">'.__('Categorías').'</span>  '.$open.'  <span class="fa arrow '.(( in_array( $actionUrl , [ 'categorias/add','categorias/index']  ) ) ? "open" : $inactiveClass).'"></span> </a>';


                echo "<ul class='sub-menu'>";
                    if($this->UserAuth->HP('Categorias', 'add', false)) {
                        echo "<li class='nav-item ".(($actionUrl=='categorias/add') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('Agregar Categoría'), ['controller'=>'Categorias', 'action'=>'add', 'plugin'=>false])."</li>";
                    }
                    if($this->UserAuth->HP('Categorias', 'index', false)) {
                        echo "<li class='nav-item ".(($actionUrl=='categorias/index') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('Listado de Categorías'), ['controller'=>'Categorias', 'action'=>'index', 'plugin'=>false])."</li>";
                    }
                echo "</ul>";
            echo "</li>";

        }

        if($this->UserAuth->HP('Banners', 'index', false)) {


            $open = (  in_array( $actionUrl , [ 'banners/add','banners/index']  )   ) ? '<span class="selected"></span>' : $inactiveClass;

            echo "<li class='nav-item ".(( in_array( $actionUrl , [ 'banners/add','banners/index']  ) ) ? $activeClass : $inactiveClass)."'>";

                 echo '<a href="#" class="nav-link nav-toggle" class="nav-link nav-toggle"> <i class="fa  fa-users"></i> <span class="nav-label">'.__('Banners').'</span>  '.$open.'  <span class="fa arrow '.(( in_array( $actionUrl , [ 'banners/add','banners/index']  ) ) ? "open" : $inactiveClass).'"></span> </a>';


                echo "<ul class='sub-menu'>";
                    if($this->UserAuth->HP('Banners', 'add', false)) {
                        echo "<li class='nav-item ".(($actionUrl=='banners/add') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('Agregar Banner'), ['controller'=>'Banners', 'action'=>'add', 'plugin'=>false])."</li>";
                    }
                    if($this->UserAuth->HP('Banners', 'index', false)) {
                        echo "<li class='nav-item ".(($actionUrl=='banners/index') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('Listado de Banners'), ['controller'=>'Banners', 'action'=>'index', 'plugin'=>false])."</li>";
                    }
                echo "</ul>";
            echo "</li>";

        }


        if($this->UserAuth->HP('Secciones', 'index', false)) {


            $open = (  in_array( $actionUrl , [ 'secciones/add','secciones/index']  )   ) ? '<span class="selected"></span>' : $inactiveClass;

            echo "<li class='nav-item ".(( in_array( $actionUrl , [ 'secciones/add','secciones/index']  ) ) ? $activeClass : $inactiveClass)."'>";

                 echo '<a href="#" class="nav-link nav-toggle" class="nav-link nav-toggle"> <i class="fa  fa-users"></i> <span class="nav-label">'.__('Secciones').'</span>  '.$open.'  <span class="fa arrow '.(( in_array( $actionUrl , [ 'secciones/add','secciones/index']  ) ) ? "open" : $inactiveClass).'"></span> </a>';


                echo "<ul class='sub-menu'>";
                    if($this->UserAuth->HP('Secciones', 'add', false)) {
                         "<li class='nav-item ".(($actionUrl=='secciones/add') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('Agregar Seccion'), ['controller'=>'Secciones', 'action'=>'add', 'plugin'=>false])."</li>";
                    }
                    if($this->UserAuth->HP('Secciones', 'index', false)) {
                        echo "<li class='nav-item ".(($actionUrl=='secciones/index') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('Listado de Secciones'), ['controller'=>'Secciones', 'action'=>'index', 'plugin'=>false])."</li>";
                    }
                echo "</ul>";
            echo "</li>";

        }

        if($this->UserAuth->HP('Promociones', 'index', false)) {


            $open = (  in_array( $actionUrl , [ 'promociones/add','promociones/index']  )   ) ? '<span class="selected"></span>' : $inactiveClass;

            echo "<li class='nav-item ".(( in_array( $actionUrl , [ 'promociones/add','promociones/index']  ) ) ? $activeClass : $inactiveClass)."'>";

                 echo '<a href="#" class="nav-link nav-toggle" class="nav-link nav-toggle"> <i class="fa  fa-users"></i> <span class="nav-label">'.__('Promociones').'</span>  '.$open.'  <span class="fa arrow '.(( in_array( $actionUrl , [ 'promociones/add','promociones/index']  ) ) ? "open" : $inactiveClass).'"></span> </a>';


                echo "<ul class='sub-menu'>";
                    if($this->UserAuth->HP('Promociones', 'add', false)) {
                         "<li class='nav-item ".(($actionUrl=='promociones/add') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('Agregar Seccion'), ['controller'=>'Promociones', 'action'=>'add', 'plugin'=>false])."</li>";
                    }
                    if($this->UserAuth->HP('Promociones', 'index', false)) {
                        echo "<li class='nav-item ".(($actionUrl=='promociones/index') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('Listado de Promociones'), ['controller'=>'Promociones', 'action'=>'index', 'plugin'=>false])."</li>";
                    }
                    if($this->UserAuth->HP('Promociones', 'suscriptores', false)) {
                        echo "<li class='nav-item ".(($actionUrl=='promociones/suscriptores') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('Descargar Suscriptores'), ['controller'=>'Promociones', 'action'=>'suscriptores', 'plugin'=>false])."</li>";
                    }
                echo "</ul>";
            echo "</li>";

        }

        if($this->UserAuth->HP('Sucursales', 'index', false)) {


            $open = (  in_array( $actionUrl , [ 'sucursales/add','sucursales/index']  )   ) ? '<span class="selected"></span>' : $inactiveClass;

            echo "<li class='nav-item ".(( in_array( $actionUrl , [ 'sucursales/add','sucursales/index']  ) ) ? $activeClass : $inactiveClass)."'>";

                 echo '<a href="#" class="nav-link nav-toggle" class="nav-link nav-toggle"> <i class="fa  fa-users"></i> <span class="nav-label">'.__('Sucursales').'</span>  '.$open.'  <span class="fa arrow '.(( in_array( $actionUrl , [ 'sucursales/add','sucursales/index']  ) ) ? "open" : $inactiveClass).'"></span> </a>';


                echo "<ul class='sub-menu'>";
                    if($this->UserAuth->HP('Sucursales', 'add', false)) {
                        echo "<li class='nav-item ".(($actionUrl=='sucursales/add') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('Agregar Sucursal'), ['controller'=>'Sucursales', 'action'=>'add', 'plugin'=>false])."</li>";
                    }
                    if($this->UserAuth->HP('Sucursales', 'index', false)) {
                        echo "<li class='nav-item ".(($actionUrl=='sucursales/index') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('Listado de Sucursales'), ['controller'=>'Sucursales', 'action'=>'index', 'plugin'=>false])."</li>";
                    }
                echo "</ul>";
            echo "</li>";

        }

        if($this->UserAuth->HP('UserSettings', 'configuracion', 'Usermgmt')) {


            $open = (  in_array( $actionUrl , [ 'usermgmt/user_settings/configuracion']  )   ) ? '<span class="selected"></span>' : $inactiveClass;

            echo "<li class='nav-item ".(( in_array( $actionUrl , [ 'usermgmt/user_settings/configuracion']  ) ) ? $activeClass : $inactiveClass)."'>";

                 echo '<a href="#" class="nav-link nav-toggle" class="nav-link nav-toggle"> <i class="fa  fa-users"></i> <span class="nav-label">'.__('Configuración').'</span>  '.$open.'  <span class="fa arrow '.(( in_array( $actionUrl , [ 'usermgmt/user_settings/configuracion']  ) ) ? "open" : $inactiveClass).'"></span> </a>';


                echo "<ul class='sub-menu'>";
                    if($this->UserAuth->HP('UserSettings', 'configuracion', 'Usermgmt')) {
                        echo "<li class='nav-item ".(($actionUrl=='usermgmt/user_settings/configuracion') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('Imágenes'), ['controller'=>'UserSettings', 'action'=>'configuracion', 'plugin'=>'Usermgmt'])."</li>";
                    }
                echo "</ul>";
            echo "</li>";

        }
        /*if($this->UserAuth->HP('Customers', 'index', 'Customers')) {

            $open = (  in_array( $actionUrl , ['customers/customers/index']  )   ) ? '<span class="selected"></span>' : $inactiveClass;

            echo "<li class='nav-item ".(( in_array( $actionUrl , ['customers/customers/index']  ) ) ? $activeClass : $inactiveClass)."'>";

                echo '<a href="#" class="nav-link nav-toggle" class="nav-link nav-toggle"> <i class="fa  fa-users"></i> <span class="nav-label">'.__('Clientes').'</span>  '.$open.'  <span class="fa arrow '.(( in_array( $actionUrl , [ 'Customers/addUser','customers/customers/index']  ) ) ? "open" : $inactiveClass).'"></span> </a>';

                echo "<ul class='sub-menu'>";
                    if($this->UserAuth->HP('Customers', 'index', 'Customers')) {
                        echo "<li class='nav-item ".(($actionUrl=='customers/customers/index') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('Listado de Clientes'), ['controller'=>'Customers', 'action'=>'index', 'plugin'=>'Customers'])."</li>";
                    }
                echo "</ul>";
            echo "</li>";

        }*/

        if($this->UserAuth->HP('UserGroups', 'index', 'Usermgmt')) {


            $open = (  in_array( $actionUrl , [ 'UserGroups/add','UserGroups/index']  )   ) ? '<span class="selected"></span>' : $inactiveClass;

            echo "<li class='nav-item ".(( in_array( $actionUrl , [ 'UserGroups/add','UserGroups/index']  ) ) ? $activeClass : $inactiveClass)."'>";

                 echo '<a href="#" class="nav-link nav-toggle" class="nav-link nav-toggle"> <i class="fa  fa-users"></i> <span class="nav-label">'.__('Groups').'</span>  '.$open.'  <span class="fa arrow '.(( in_array( $actionUrl , [ 'UserGroups/add','UserGroups/index']  ) ) ? "open" : $inactiveClass).'"></span> </a>';


                echo "<ul class='sub-menu'>";
                    if($this->UserAuth->HP('UserGroups', 'add', 'Usermgmt')) {
                        echo "<li class='nav-item ".(($actionUrl=='UserGroups/add') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('Add Group'), ['controller'=>'UserGroups', 'action'=>'add', 'plugin'=>'Usermgmt'])."</li>";
                    }
                    if($this->UserAuth->HP('UserGroups', 'index', 'Usermgmt')) {
                        echo "<li class='nav-item ".(($actionUrl=='UserGroups/index') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('All Groups'), ['controller'=>'UserGroups', 'action'=>'index', 'plugin'=>'Usermgmt'])."</li>";
                    }
                echo "</ul>";
            echo "</li>";

        }


        /*if($this->UserAuth->HP('Franquicias', 'index', false)) {


            $open = (  in_array( $actionUrl , [ 'Franquicias/add','Franquicias/index']  )   ) ? '<span class="selected"></span>' : $inactiveClass;

            echo "<li class='nav-item ".(( in_array( $actionUrl , [ 'Franquicias/add','Franquicias/index']  ) ) ? $activeClass : $inactiveClass)."'>";

                 echo '<a href="#" class="nav-link nav-toggle" class="nav-link nav-toggle"><span class="nav-label">'.__('Franquicias').'</span>  '.$open.'  <span class="fa arrow '.(( in_array( $actionUrl , [ 'Franquicias/add','Franquicias/index']  ) ) ? "open" : $inactiveClass).'"></span> </a>';


                echo "<ul class='sub-menu'>";
                    if($this->UserAuth->HP('Franquicias', 'add', '')) {
                        echo "<li class='nav-item ".(($actionUrl=='Franquicias/add') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('Agregar Franquicia'), ['controller'=>'Franquicias', 'action'=>'add', 'plugin'=>false])."</li>";
                    }
                    if($this->UserAuth->HP('Franquicias', 'index', '')) {
                        echo "<li class='nav-item ".(($actionUrl=='Franquicias/index') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('Listado de Franquicias'), ['controller'=>'Franquicias', 'action'=>'index', 'plugin'=>false])."</li>";
                    }
                echo "</ul>";
            echo "</li>";

        }*/

        if(
            $this->UserAuth->HP('UserGroupPermissions', 'permissionGroupMatrix', 'Usermgmt')    ||
            $this->UserAuth->HP('UserGroupPermissions', 'permissionSubGroupMatrix', 'Usermgmt') ||
            $this->UserAuth->HP('UserSettings', 'index', 'Usermgmt')                            ||
            $this->UserAuth->HP('UserSettings', 'cakelog', 'Usermgmt')                          ||
            $this->UserAuth->HP('Users', 'deleteCache', 'Usermgmt')
        ){
            echo "<li class='nav-item '>";
                                   
                echo '<a href="#" class="nav-link nav-toggle"> <span class="nav-label">'.__('Admin').'</span> <span class="fa arrow"></span> </a>';

                echo "<ul class='sub-menu'>";
                    if($this->UserAuth->HP('UserGroupPermissions', 'permissionGroupMatrix', 'Usermgmt')) {
                        echo "<li class='nav-item ".(($actionUrl=='UserGroupPermissions/permissionGroupMatrix') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('Group Permissions'), ['controller'=>'UserGroupPermissions', 'action'=>'permissionGroupMatrix', 'plugin'=>'Usermgmt'])."</li>";
                    }
                    if($this->UserAuth->HP('UserGroupPermissions', 'permissionSubGroupMatrix', 'Usermgmt')) {
                        echo "<li class='nav-item ".(($actionUrl=='UserGroupPermissions/permissionSubGroupMatrix') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('Subgroup Permissions'), ['controller'=>'UserGroupPermissions', 'action'=>'permissionSubGroupMatrix', 'plugin'=>'Usermgmt'])."</li>";
                    }
                    if($this->UserAuth->HP('UserSettings', 'index', 'Usermgmt')) {
                        echo "<li class='nav-item ".(($actionUrl=='UserSettings/index') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('All Settings'), ['controller'=>'UserSettings', 'action'=>'index', 'plugin'=>'Usermgmt'])."</li>";
                    }
                    if($this->UserAuth->HP('UserSettings', 'cakelog', 'Usermgmt')) {
                        echo "<li class='nav-item ".(($actionUrl=='UserSettings/cakelog') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('Cake Logs'), ['controller'=>'UserSettings', 'action'=>'cakelog', 'plugin'=>'Usermgmt'])."</li>";
                    }
                    if($this->UserAuth->HP('Users', 'deleteCache', 'Usermgmt')) {
                        echo "<li>".$this->Html->link(__('Delete Cache'), ['controller'=>'Users', 'action'=>'deleteCache', 'plugin'=>'Usermgmt'])."</li>";
                    }
                echo "</ul>";
            echo "</li>";
        }

        if($this->UserAuth->HP('UserEmails', 'index', 'Usermgmt')){
            echo "<li class='nav-item '>";
                


                echo '<a href="#" class="nav-link nav-toggle"> <span class="nav-label">'.__('Email').'</span> <span class="fa arrow"></span> </a>';


                echo "<ul class='sub-menu'>";
                    if($this->UserAuth->HP('UserEmails', 'send', 'Usermgmt')) {
                        echo "<li class='nav-item ".(($actionUrl=='UserEmails/send') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('Send Email'), ['controller'=>'UserEmails', 'action'=>'send', 'plugin'=>'Usermgmt'])."</li>";
                    }
                    if($this->UserAuth->HP('UserEmails', 'index', 'Usermgmt')) {
                        echo "<li class='nav-item ".(($actionUrl=='UserEmails/index') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('View Sent Emails'), ['controller'=>'UserEmails', 'action'=>'index', 'plugin'=>'Usermgmt'])."</li>";
                    }
                    if($this->UserAuth->HP('ScheduledEmails', 'index', 'Usermgmt')) {
                        echo "<li class='nav-item ".(($actionUrl=='ScheduledEmails/index') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('Scheduled Mails'), ['controller'=>'ScheduledEmails', 'action'=>'index', 'plugin'=>'Usermgmt'])."</li>";
                    }
                    if($this->UserAuth->HP('UserContacts', 'index', 'Usermgmt')) {
                        echo "<li class='nav-item ".(($actionUrl=='UserContacts/index') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('Contact Enquiries'), ['controller'=>'UserContacts', 'action'=>'index', 'plugin'=>'Usermgmt'])."</li>";
                    }
                    if($this->UserAuth->HP('UserEmailTemplates', 'index', 'Usermgmt')) {
                        echo "<li class='nav-item ".(($actionUrl=='UserEmailTemplates/index') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('Email Templates'), ['controller'=>'UserEmailTemplates', 'action'=>'index', 'plugin'=>'Usermgmt'])."</li>";
                    }
                    if($this->UserAuth->HP('UserEmailSignatures', 'index', 'Usermgmt')) {
                        echo "<li class='nav-item ".(($actionUrl=='UserEmailSignatures/index') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('Email Signatures'), ['controller'=>'UserEmailSignatures', 'action'=>'index', 'plugin'=>'Usermgmt'])."</li>";
                    }
                echo "</ul>";
            echo "</li>";
        }

        if($this->UserAuth->HP('StaticPages', 'index', 'Usermgmt')){
            echo "<li class='nav-item '>";

                 echo '<a href="#" class="nav-link nav-toggle"> <span class="nav-label">'.__('Pages').'</span> <span class="fa arrow"></span> </a>';


                echo "<ul class='sub-menu'>";
                    if($this->UserAuth->HP('StaticPages', 'add', 'Usermgmt')) {
                        echo "<li class='nav-item ".(($actionUrl=='StaticPages/add') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('Add Page'), ['controller'=>'StaticPages', 'action'=>'add', 'plugin'=>'Usermgmt'])."</li>";
                    }
                    if($this->UserAuth->HP('StaticPages', 'index', 'Usermgmt')) {
                        echo "<li class='nav-item ".(($actionUrl=='StaticPages/index') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('All Pages'), ['controller'=>'StaticPages', 'action'=>'index', 'plugin'=>'Usermgmt'])."</li>";
                    }
                echo "</ul>";
            echo "</li>";
        }

        if($this->UserAuth->isAdmin()){

            echo "<li class='nav-item '>";

                echo '<a href="#" class="nav-link nav-toggle"> <span class="nav-label">'.__('Demos').'</span> <span class="fa arrow"></span> </a>';
                echo "<ul class='sub-menu'>";
                if($this->UserAuth->HP('Demos', 'pdf')) {

                    echo "<li class='nav-item ".(($actionUrl=='Demos/pdf') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('Demo Pdf'), ['controller'=>'Demos', 'action'=>'pdf' , 'plugin'=>false])."</li>";
                }


                if($this->UserAuth->HP('Demos', 'pdfCell')) {


                    echo "<li class='nav-item ".(($actionUrl=='Demos/pdfCell') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('Demo Pdf Cell'), ['controller'=>'Demos', 'action'=>'pdfCell' , 'plugin'=>false])."</li>";


                }

                if($this->UserAuth->HP('Demos', 'graficasImg')) {


                    echo "<li class='nav-item ".(($actionUrl=='Demos/graficasImg') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('Demo Graficas IMG'), ['controller'=>'Demos', 'action'=>'graficasImg' , 'plugin'=>false])."</li>";


                }

                if($this->UserAuth->HP('Demos', 'correo')) {


                    echo "<li class='nav-item ".(($actionUrl=='Demos/correo') ? $activeClass : $inactiveClass)."'>".$this->Html->link(__('Demo Correo EWS'), ['controller'=>'Demos', 'action'=>'correo' , 'plugin'=>false])."</li>";


                }
                echo '</ul>';



            echo '</li>';
        }

    }
