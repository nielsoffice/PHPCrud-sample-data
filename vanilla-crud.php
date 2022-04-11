<?php 

  session_start();

  /**
  * Defined: PHPWine Crud sample data support v1.3.1.0  
  * @since 10.04.2022
  */
  $PHPWineCrudVanilla = new class {
        
 /**
  * @var 
  * @property Object vanilla
  * Defined $vanilla : table property string object
  * @since v1.3.1.0
  * @since 03.11.2022
  **/
    private object $vanilla;

 /**
  * @var 
  * @property Object wine_db
  * Defined $wine_db : table property string object
  * @since v1.3.1.0
  * @since 03.11.2022
  **/
    private object $wine_db;

 /**
  * @var 
  * @property String read
  * Defined $read : table property string|array
  * @since v1.3.1.0
  * @since 03.11.2022
  **/
    private array|string $read;

 /**
  * @var 
  * @property String create
  * Defined $create : table property string|array
  * @since v1.3.1.0
  * @since 03.11.2022
  **/
    private array|string $create;

 /**
  * @var 
  * @property String friend_name
  * Defined $friend_name : table property string 
  * @since v1.3.1.0
  * @since 03.11.2022
  **/
    private string $friend_name;

 /**
  * @var 
  * @property String friend_mobile
  * Defined $friend_mobile : table property string 
  * @since v1.3.1.0
  * @since 03.11.2022
  **/
    private string $friend_mobile;

 /**
  * @var 
  * @property String friend_email
  * Defined $friend_email : table property string 
  * @since v1.3.1.0
  * @since 03.11.2022
  **/
    private string $friend_email;

 /**
  * @var 
  * @property String|int friend_id
  * Defined $friend_id : table property string 
  * @since v1.3.1.0
  * @since 03.11.2022
  **/
    private string|int $friend_id;

 /**
  * @var 
  * @property bool updateRequest
  * Defined $updateRequest : table property bool 
  * @since v1.3.1.0
  * @since 03.11.2022
  **/
    private bool $updateRequest = false;

    public function __construct() {
        
      // define('PHPWINE_MINIFIED', true );
  
      $this->php_wine('autoload');

      $this->vanilla = new \PHPWineVanillaFlavour\Plugins\PHPCrud\Crud\Vanilla;
      $this->wine_db = $this->vanilla->wine_db();

      new \PHPWineVanillaFlavour\Wine\Optimizer\Html; // If incase Child element undefined constant array CHILD 
      new \PHPWineVanillaFlavour\Wine\Optimizer\ENHANCER_ELEM; 
      new \PHPWineVanillaFlavour\Wine\Optimizer\ENHANCER_ATTR;
      new \PHPWineVanillaFlavour\Wine\Optimizer\ENHANCER_DOIF;  
      new \PHPWineVanillaFlavour\Wine\Optimizer\HTML_DIV;
      new \PHPWineVanillaFlavour\Wine\Optimizer\HTML_UL;
      new \PHPWineVanillaFlavour\Wine\Optimizer\HTML_LI;
      new \PHPWineVanillaFlavour\Wine\Optimizer\HTML_FORM;

      $this->wine_vanilla_crud();
      $this->wine_rendred();
      $this->wine_page_output();
 
    }

  /**
   * Defined: Incase of Create 
   * @since v1.3.1.0
   * @since 04.11.2022
   **/ 
    private function wine_insert_data() : void {
  
        if(isset($_REQUEST['insertData']) == true ) {

             /**
              * @var  
              * defined Initialized update 
              * NOTE ! This CRUD demo for [ PHPCrud Vanilla  ] have no include sanitation for the simplicity reason. 
              **/              
             $this->create  = $this->vanilla->wine_creates( 'crud' , [ 
                 
                'friend_name'   => '?',
                'friend_mobile' => '?',
                'friend_email'  => '?'
            
             ] , "sss" , array(
                    
              trim($_POST['friend_name'])   ?? '',
              trim($_POST['friend_mobile']) ?? '',
              trim($_POST['friend_email'])  ?? ''
            
             )); 
             
             if( !empty($this->create) ) { 

               $_SESSION['create'] = "Last_id : " . $this->create . " Added new record! ";
                
               header("location: vanilla-crud.php?create-succesfully"); 
            
             } 

        }

    }

  /**
   * Defined: Incase of Read 
   * @since v1.3.1.0
   * @since 04.11.2022
   **/ 
    private function wine_fetch_data() : void { 
        
        $this->read = $this->vanilla->wine_fetch( 'crud', [ 'mixed' => [ "SELECT * FROM  Crud ORDER BY friend_id DESC " ]  ] 
          
        , function( $read )  {  
           
            $friends = array(); if( $read )  { 
              
             foreach ($read as $value) {  
                
                $friends[] = ELEM('tr', [ CHILD => [
           
                   ['td', ATTR  => [ "scope" => "col" ] , VALUE => [ $value["friend_name"]  ] ],
                   ['td', VALUE => [ $value["friend_mobile"] ] ],
                   ['td', VALUE => [ $value["friend_email"]  ] ],
                   ['th', VALUE => [ ELEM('a', ELEM('i','', [['class','aria-hidden'],['fa fa-pencil','true']]) ,[['href'],['vanilla-crud.php?edit='.$value["friend_id"] .'']]) ]  ],
                   ['th', VALUE => [ ELEM('a', ELEM('i','', [['class','aria-hidden'],['fa fa-trash' ,'true']]) ,[['href'],['vanilla-crud.php?delete='.$value["friend_id"] .'']])  ]  ] 
                    
                  ]
                
                ]);
               
            }  return (array)  $friends ;
           
           } 
            
           return [];
           
       });
   
    }

  /**
   * Defined: Incase of Edit 
   * @since v1.3.1.0
   * @since 04.11.2022
   **/ 
    private function wine_edit_data() : void {

      if (isset($_REQUEST['edit']) == true ) :
     
         $this->updateRequest  = true; 
         
         $friend_id      = $_REQUEST['edit'];
     
         $friend = $this->vanilla->wine_fetch( '' , [
            
            'mixed' => [" SELECT * FROM Crud WHERE friend_id = ". $friend_id ] 
        
         ], function ( $friend ) {
            
            if($friend) { foreach($friend as $val ) { return $val; } }

         });
       
         $this->friend_name    =  $friend['friend_name'];
         $this->friend_mobile  =  $friend['friend_mobile'];
         $this->friend_email   =  $friend['friend_email'];
         $this->friend_id      =  $friend_id;
        
      endif;
 
    }

  /**
   * Defined: Incase of Update 
   * @since v1.3.1.0
   * @since 04.11.2022
   **/ 
    private function wine_update_data() : void {

      if(isset($_REQUEST['updateData']) == true ) : 

         $this->vanilla->wine_update('crud', [
       
         'friend_name'   => $_REQUEST['friend_name'],
         'friend_mobile' => $_REQUEST['friend_mobile'],
         'friend_email'  => $_REQUEST['friend_email'],
     
         'condition'     => [' WHERE friend_id = '. $_REQUEST['friend_id'] ]
     
        ] , function( $do_update ) { if( $do_update ) {
  
           $_SESSION['update'] = 'Succesfully Friend Updated !';

           header("location: vanilla-crud.php?update-succesfully");         

         } 
    
        });
     
      endif;

    }

  /**
   * Defined: Incase of Delete 
   * @since v1.3.1.0
   * @since 04.11.2022
   **/ 
    private function wine_delete_data() : void {

      if( isset($_REQUEST['delete']) == true ) :
   
         $deleted_friend   = $_REQUEST['delete'];
         
         $this->vanilla->wine_delete( '', [
         
         'crud',
         'condition' => [" WHERE friend_id  = ". $deleted_friend ] 
       
        ],  function ( $deleted_friend ) {
       
        if( $deleted_friend )  {

           $_SESSION['delete'] = 'Succesfully Friend Deleted !';

           header("location: vanilla-crud.php?delete-succesfully");

        }

       });
       
        endif;  

    }

  /**
   * Defined: Execution methods 
   * @since v1.3.1.0
   * @since 04.11.2022
   **/ 
    private function wine_vanilla_crud() : void {

      if($this->wine_db === false ) { die("ERROR: Could not connect. " . $this->wine_db->connect_error); }

      $this->wine_insert_data();
      $this->wine_fetch_data();
      $this->wine_edit_data();
      $this->wine_update_data();
      $this->wine_delete_data();

      $this->wine_db->close();

    }

  /**
   * Defined: Execution session message error 
   * @since v1.3.1.0
   * @since 04.11.2022
   **/ 
    private function wine_session_msg() : void {

      print ul(function () {

        $session_msg = "";
       
        if( isset($_GET['create-succesfully']) ) { $session_msg .= li( $_SESSION['create'] ); } 
        if( isset($_GET['update-succesfully']) ) { $session_msg .= li( $_SESSION['update'] );  } 
        if( isset($_GET['delete-succesfully']) ) { $session_msg .= li( $_SESSION['delete'] );  } 
  
        if( !empty($session_msg)) {

            return $session_msg;      
        } 

      });               
       
      
    }

  /**
   * Defined: CRUD output
   * @since v1.3.1.0
   * @since 04.11.2022
   **/ 
    private function wine_page_output() : void {

      $this->wine_insert_form();
      $this->wine_page_footer();
       
    }

  /**
   * Defined: Form insert data 
   * @since v1.3.1.0
   * @since 04.11.2022
   **/ 
    private function wine_insert_form() : void  {
       
      print form(function()  {

       return div([
              
            CHILD => [  

               ['div', ATTR  => ['class' => 'col-md-12']  
                     , INNER => [ 
                  ['label', ATTR => [ 'type' => 'label' , 'id' => 'friend_name' ], VALUE => [ 'Friend Name : '] ],
                  ['input', ATTR => [ 
                    'type'  => 'text', 
                    'id'    => 'id-friend_name', 
                    'name'  => 'friend_name' ,
                    'value' => ($this->friend_name?? '') 
                    ]]         
               ]],
               ['div', ATTR => ['class' => 'col-md-12'] , INNER => [ 
                  ['label', ATTR => [ 'type' => 'label' , 'id' => 'friend_mobile' ], VALUE => [ 'Friend Mobile : '] ],
                  ['input', ATTR => [ 
                        'type'  => 'text', 
                        'id'    => 'id-friend_mobile', 
                        'name'  => 'friend_mobile' ,
                        'value' => ($this->friend_mobile?? '') 
                        ]]
               ]],
               ['div', ATTR => ['class' => 'col-md-12'] , INNER => [ 
                  ['label', ATTR => [ 'type' => 'label' , 'id' => 'friend_email' ], VALUE => [ 'Friend Email :'] ],
                  ['input', ATTR => [ 
                        'type'  => 'text', 
                        'id'    => 'id-friend_email', 
                        'name'  => 'friend_email' ,
                        'value' => ($this->friend_email?? '') 
                        ]],
                  ['input', ATTR => [ 
                        'type'  => 'hidden', 
                        'name'  => 'friend_id' ,
                        'value' => ($this->friend_id?? '') 
                        ]]
               ]],
               ['div', ATTR => ['class' => 'col-md-12'] , VALUE => [
                  
               ( $this->updateRequest  ) ? ELEM('button','Update friend',[['type','name'],['submit','updateData']] ) 
               
               : div( [ CHILD => [
                    ['input', ATTR => [ 
                      'type'  => 'submit', 
                      'name'  => 'insertData' ,
                      'value' => 'Submit' 
                    ]],
                    ['input', ATTR => [ 
                      'type'  => 'reset', 
                      'value' => 'Reset !' 
                     ]]
                  ]])
               ]],

          ]]
    
          , [['class'],['container']]);
       
        }, attr : [['action','method'],[ htmlspecialchars($_SERVER["PHP_SELF"]), 'POST']] );

    }

  /**
   * Defined: Winde rendered  method 
   * @since v1.3.1.0
   * @since 04.11.2022
   **/ 
    private function wine_rendred() : void  { 

      print $this->wine_session_msg() . div(function() {
          
      return ELEM( 'table', [ CHILD => [
      
          ['thead', VALUE => [ ELEM( 'tr', [ CHILD => [
     
                 ['th', ATTR => [ "scope" => "col" ], VALUE => [ "Friend Name:" ]   ],
                 ['th', ATTR => [ "scope" => "col" ], VALUE => [ "Friend Mobile:" ] ],
                 ['th', ATTR => [ "scope" => "col" ], VALUE => [ "Friend Email:" ]  ],
                 ['th', ATTR => [ "scope" => "col" ], VALUE => [ ELEM('i','', [['class','aria-hidden'],['fa fa-pencil','true']]) ]  ],
                 ['th', ATTR => [ "scope" => "col" ], VALUE => [ ELEM('i','', [['class','aria-hidden'],['fa fa-trash' ,'true']]) ]  ] 
              
               ]])   
             ]
          ],
          ['tbody', VALUE => [ $this->vanilla->wine_extract($this->read)  ] 
        
         ]]
     
       ] 
       , [['class'],['table table-hover ']]);

      }, [['class'],['fluid-container']] );
    
    }

  /**
   * Defined: Bootstrap
   * @since v1.3.1.0
   * @since 04.11.2022
   **/ 
    private function wine_page_footer() : void {

      print  ATTR( 'LINK' , [
         
         'b5.1' => [
         
            'href'         => 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css'
          , 'rel'          => 'stylesheet'
          , 'integrity'    => 'sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3'
          , 'crossorigin'  => 'anonymous'
      
         ],
         
          'font-awesome' => [
       
            'href'         => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'
          , 'rel'          => 'stylesheet'
       
          ]
      
      ]) .
      
      ATTR( 'SCRIPT' , [
         
          'b5.1' => [
          
             'src'          => 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js'
           , 'integrity'    => 'sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p'
           , 'crossorigin'  => 'anonymous'
       
          ]
       
       ]);

    }

  /**
   * Defined: PHPwine Loader 
   * @since v1.3.1.0
   * @since 04.11.2022
   **/
    private function php_wine(string $autoload) : void {

      require dirname(__FILE__) . DIRECTORY_SEPARATOR .'vendor/' . $autoload.'.'.'php';

    }

 }; 

 # Fixed Element array inline removed closing tag 
   # Such as : [ 'source' ,'track' ,'circle' ,'param' ,'input' ,'meta' ,'link' ,'img' ,'embed' ,'option' ,'col' ,'base' ,'aside' ,'area' ,'DOCTYPE html' ]
 # Fixed Element array Inner removed white space end tag
 # Removed | Deprecated : Merge 
 # Replace | Merge version into Callable type value 

