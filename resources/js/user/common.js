(function() {
  var _doc = document, _win = window;
  $( _doc ).ready( function() {
    //スムーススクロール
    $( 'a[ href^="#" ]' ).click(function(){
      var speed = 500;
      var href= $( this ).attr( "href" );
      var target = $( href == "#" || href == "" ? 'html' : href );
      var position = target.offset().top;
      $( "html, body" ).animate( { scrollTop: position }, speed, "swing" );
      return false;
    });
    //イントロ
    var $catch = $( '#catch' );
    setTimeout( function() {
      $catch.addClass( 'active' );
    }, 1000 );
    //スライダー
    $( '.slide' ).slick( {
      autoplay: true,
      arrows: false,
      dots: true,
      infinite: true,
      slidesToShow: 4,
      slidesToScroll: 4,
      responsive: [
        {
          breakpoint: 1028,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
          }
        },
        {
          breakpoint: 688,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
          }
        }
      ]
    } );
    $( '.slide-2' ).slick( {
      autoplay: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      fade: true,
      asNavFor: '.slide-3'
    } );
    $( '.slide-3' ).slick( {
      autoplay: true,
      slidesToShow: 5,
      slidesToScroll: 1,
      asNavFor: '.slide-2',
      centerMode: true,
      focusOnSelect: true,
      vertical: true,
      verticalSwiping: true
    } );
    //メニュー
    var $menu_btn = $( '#menu-btn' ), $menu = $( '#menu-sp' );
    $menu_btn.on( 'click', function() {
      var $this = $( this );
      if ( $this.hasClass( '_opened' ) ) {
        $this.removeClass( '_opened' );
        $menu.animate( { opacity: 0 }, { duration: 300, queue: false, complete: function() {
          $( this ).css( { display: 'none' } );
        } } );
      } else {
        $this.addClass( '_opened' );
        $menu.css( { display: 'block' } ).animate( { opacity: 1 }, { duration: 300, queue: false } );
      }
    } );

    //キャンセル
    var $cancel = $( '.cancel' ), $modal = $( '#modal-wrap' ), $close = $( '#close' );
    $cancel.on( 'click', function() {
      $modal.css( { display: 'block' } ).animate( { opacity: 1 }, { duration: 300, queue: false } );
    } );
    $modal.on( 'click', function() {
      $modal.css( { display: 'none', opacity: '0' } );
    } );
    $close.on( 'click', function() {
      $modal.css( { display: 'none', opacity: '0' } );
    } );

    //検索メニュー
    var $calinput = $( '.cal-input' ), $calclose = $( '#cal-close' ), $brabtn = $( '#brand-btn' ), $braclose = $( '#bra-close' );
    $calinput.on( 'focus', function() {
      $( '#cal-box' ).css( { display: 'block' } );
      $( '#bra-box' ).css( { display: 'none' } );
    } );
    $calclose.on( 'click', function() {
      $( '#cal-box' ).css( { display: 'none' } );
    } );
    $brabtn.on( 'click', function() {
      $( '#bra-box' ).css( { display: 'block' } );
      $( '#cal-box' ).css( { display: 'none' } );
    } );
    $braclose.on( 'click', function() {
      $( '#bra-box' ).css( { display: 'none' } );
    } );

    //アコーディオン
    var $unit = $( '.faq-unit' );
    $unit.each( function() {
      var $this = $( this ), $ques = $this.find( '.ques' ), $answ = $this.find( '.faq-unit-inner' );
      $answ.data( 'h', $answ.outerHeight() ).css( { height: '0' } );
      $ques.on( 'click', function() {
        var $this = $( this );
        if ( $this.hasClass( '_opened' ) ) {
          $this.removeClass( '_opened' );
          $answ.animate( { height: '0' }, { duration: 300, queue: false } );
        } else {
          $this.addClass( '_opened' );
          $answ.animate( { height: $answ.data( 'h' ) + 'px' }, { duration: 300, queue: false } );
        }
      } );
    } );

    var $p_list = $( '.product-list-C' ), $p_item = $p_list.children( '.item' ), $more = $( '#more-btn' );
    $p_list.data( 'h', $p_list.outerHeight() );
    $p_list.css( { height: $p_item.eq( 9 ).position().top + $p_item.eq( 9 ).outerHeight() + 'px' } );

    $more.on( 'click', function() {
      $p_list.animate( { height: $p_list.data( 'h' ) + 'px' }, { duration: 300, queue: false, complete: function() {
        $more.remove();
      } } );
    } );

  });
})();
