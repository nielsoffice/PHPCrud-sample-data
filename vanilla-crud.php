<?php require dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library/PHPWine/PHPWine.php'; ?>
<?php 

 use \PHPWine\VanillaFlavour\Wine\Optimizer\Html as Optimizer;
 use \PHPWine\VanillaFlavour\Wine\Optimizer\Enhancers as OptimizerCare; 
 use \PHPWine\VanillaFlavour\Wine\Optimizer\Form; 
 use \PHPWine\VanillaFlavour\Plugins\PHPCrud\Crud\Vanilla;

 $noHtml     = new Optimizer();
 $enhancer   = new OptimizerCare();
 $phpCrud    = new Vanilla();

// Request vanilla public connection 
$wine_db = $phpCrud->wine_db();

 _HTML(  [['class','lang'],['no-js','']] );
 _HEAD();

 ATTR( 'META', [

  "meta-charset"  => [ 'charset'    => "utf-8"],
  "meta-compat"   => [ 'http-equiv' => "x-ua-compatible" , 'content'  => "" ],
  "meta-des"      => [ 'name'       => "description"     , 'content'  => "" ],
  "meta-vport"    => [ 'name'       => "viewport"        ,  'content' => "width=device-width, initial-scale=1" ]

 ]); 

 ATTR('TITLE', ' PHPCrud Vanilla : Bootstrap '); 

 _xSTYLE('input { width: 100%; }');

 xHEAD();
 _BODY();

 ############################################################################################### 

 # DO INSERT / CREATE 

 if( $wine_db === false ) { die("ERROR: Could not connect. " . $wine_db->connect_error); }

 if(isset($_REQUEST['insertData']) == true ) : 

/**
  * @var  
  * defined Initialized update 
  * NOTE ! This CRUD demo for [ PHPCrud Vanilla  ] have no include sanitation for the simplicity reason. 
  **/  
 $friend_name   = ($_POST['friend_name'])   ?? '';
 $friend_mobile = ($_POST['friend_mobile']) ?? '';
 $friend_email  = ($_POST['friend_email'])  ?? '';

 $create  = $phpCrud->wine_creates( 'crud' , [ 
     
    'friend_name'   => '?',
    'friend_mobile' => '?',
    'friend_email'  => '?'

 ] , "sss" , array(
        
    $friend_name,
    $friend_mobile,
    $friend_email

 )); 
 
 echo ( !empty($create) ) ? "Last_id : {$create} Added new record! " : ''; 

endif;

 # DO READ DATA FROM DATABASE

 $read = $phpCrud->wine_fetch( 'crud', [ 'mixed' => [ "SELECT * FROM  Crud ORDER BY frined_id DESC " ]  ] , 'get_all_friends' );
  
 function get_all_friends( $read )  {  
    
 $friends = array(); if( $read )  { 
   
  foreach ($read as $value) {  
     
     $friends[] = ELEM('tr', [ CHILD => [

        ['td', ATTR  => [ "scope" => "col" ] , VALUE => [ $value["friend_name"]  ] ],
        ['td', VALUE => [ $value["friend_mobile"] ] ],
        ['td', VALUE => [ $value["friend_email"]  ] ],
        ['th', VALUE => [ ELEM('a', ELEM('i','', [['class','aria-hidden'],['fa fa-pencil','true']]) ,[['href'],['vanilla-crud.php?edit='.$value["frined_id"] .'']]) ]  ],
        ['th', VALUE => [ ELEM('a', ELEM('i','', [['class','aria-hidden'],['fa fa-trash' ,'true']]) ,[['href'],['vanilla-crud.php?delete='.$value["frined_id"] .'']])  ]  ] 
         
       ]
     
     ]);
    
 }  return (array)  $friends ;

} 
   return [];

 }
 
 # DO EDIT

 $updateRequest = 0;

 if (isset($_REQUEST['edit']) == true ) :

    $updateRequest  = true; 
    
    $friend_id      = $_REQUEST['edit'];
    
    function edit_friend( $friend )
    {
       if($friend) { foreach($friend as $val ) { return $val; } }
    }

    $friend = $phpCrud->wine_fetch( '' , [
       
       'mixed' => [" SELECT * FROM Crud WHERE frined_id = ". $friend_id ] 
   
    ], 'edit_friend' );
  
    $friend_name    =  $friend['friend_name'];
    $friend_mobile  =  $friend['friend_mobile'];
    $friend_email   =  $friend['friend_email'];
    $friend_id      =  $friend_id;
   
 endif;
 
 if(isset($_REQUEST['updateData']) == true ) : 

    function do_update( $do_update ) { 
       
     echo ( $do_update ) ? 'Succesfully Friend Updated !' : '' ;
     header("location: vanilla-crud.php");

    }
     
    $do_update      = new Vanilla(Vanilla::PUT , 'crud', [
  
    'friend_name'   => $_REQUEST['friend_name'],
    'friend_mobile' => $_REQUEST['friend_mobile'],
    'friend_email'  => $_REQUEST['friend_email'],

    'condition'     => [' WHERE frined_id = '. $_REQUEST['friend_id'] ]

   ] , 'do_update' );

 endif;

 if( isset($_REQUEST['delete']) == true ) :
   
  $deleted_friend   = $_REQUEST['delete'];

  function deleted_friend( $deleted_friend ) {

    echo ( $deleted_friend ) ? 'Succesfully Friend Deleted !' : '' ;
    header("location: vanilla-crud.php");

  }

  $deleted_friend  = new Vanilla(Vanilla::DELETE , '', [
  
  'crud',
  'condition' => [" WHERE frined_id  = ". $deleted_friend ] 

 ], 'deleted_friend'  );

 endif;  

 $wine_db->close();


 ###############################################################################################

 _div([['class'],['fluid-container']]);

 // Create or Insert data to database form
 _FORM( attr : setElemAttr(['action','method'],[ htmlspecialchars($_SERVER["PHP_SELF"]), 'POST']));

 $addfriend_form = _xdiv( 'add_friends' ,
    
      ELEM('div', [
        
        CHILD => [  
        
          ['div', ATTR => ['class' => 'col-md-12'], VALUE => [ 

             FORM::LABEL('friend_name','Friend Name : ') . __BR()
            .FORM::TEXT('id-friend_name','class-friend_name',[['name','value'],['friend_name', (($friend_name))?? '']] )
  
           ] ],
           ['div', VALUE => [ 

             FORM::LABEL('friend_mobile','Friend Mobile : ') . __BR()
            .FORM::TEXT('id-friend_mobile','class-friend_mobile',[['name','value'],['friend_mobile', (($friend_mobile)?? '')]])
  
          ] ],
          ['div', VALUE => [ 

             FORM::LABEL('friend_email','Friend Email : ' ) . __BR()
            .FORM::TEXT('id-friend_mobile','class-friend_mobile',[['name','value'],['friend_email', (($friend_email)?? '')]])
            .FORM::HIDDEN('id-friend_mobile','class-friend_mobile',[['name','value'],['friend_id', (($friend_id)?? '')]])

         ] ],
         ['div', VALUE => [ 

             DOIF($updateRequest == true  , ELEM('button','Update friend',[['type','name'],['submit','updateData']] ))
            .DOIF($updateRequest == false ,  
                 
                 FORM::BUTTONS('id-conPassword','class-submit',[['name','value'],['insertData','Submit']] ) 
                .FORM::RESET('id-conPassword','class-submit',[['value'],['Reset' ]] ) 
             )

        ] ]

      ]])

      , [['class'],['container']]
  );

 xFORM(" END Of the form ");

# DISPLAY DATA FROM DATABASE 

 _div([['class'],['fluid-container']]);
   
 _xdiv( 'friend_list', ELEM( 'table', [ CHILD => [
      
     ['thead', VALUE => [ ELEM( 'tr', [ CHILD => [

            ['th', ATTR => [ "scope" => "col" ], VALUE => [ "Friend Name:" ]   ],
            ['th', ATTR => [ "scope" => "col" ], VALUE => [ "Friend Mobile:" ] ],
            ['th', ATTR => [ "scope" => "col" ], VALUE => [ "Friend Email:" ]  ],
            ['th', ATTR => [ "scope" => "col" ], VALUE => [ ELEM('i','', [['class','aria-hidden'],['fa fa-pencil','true']]) ]  ],
            ['th', ATTR => [ "scope" => "col" ], VALUE => [ ELEM('i','', [['class','aria-hidden'],['fa fa-trash' ,'true']]) ]  ] 
         
          ]])   
        ]
     ],
     ['tbody', VALUE => [ vanilla::wine_extract($read)  ] 
   
    ]]

  ] 

  , [['class'],['table table-hover ']])
  , [['class'],['container']] );

 xdiv(' END OF read data ! ');

xFOOTER();

ATTR( 'LINK' , [
   
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

]);

ATTR( 'SCRIPT' , [
   
    'b5.1' => [
    
       'src'          => 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js'
     , 'integrity'    => 'sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p'
     , 'crossorigin'  => 'anonymous'
 
    ]
 
 ]);

 xFOOTER();
 xBODY();
 xHTML();
