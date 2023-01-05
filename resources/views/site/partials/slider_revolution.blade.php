<div class="column-3_4 sc_column_item sc_column_item_2span_3">
    <div id="rev_slider_1_1_wrapper" class="rev_slider_wrapper fullwidthbanner-container slider_wrap" data-source="gallery">
        <!-- START REVOLUTION SLIDER -->
        <div id="rev_slider_1_1" class="rev_slider fullwidthabanner" data-version="5.4.3">
            <ul>
               @foreach($sliderImage  as $row)
                <!-- SLIDE 1 -->
                <li data-index="rs-1" data-transition="fade" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off" data-easein="default" data-easeout="default" data-masterspeed="300" data-thumb="" data-rotate="0" data-saveperformance="off" data-title="Slide" data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-param10="" data-description="">
                    <!-- MAIN IMAGE -->
                    <img src="js/vendor/revslider/images/transparent.png" data-bgcolor='#000000' alt="" title="Home 1" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg" data-no-retina>
                    <!-- LAYERS -->
                    <!-- LAYER NR. 1 -->
                    <div class="tp-caption tp-resizeme" id="slide-1-layer-1" data-x="center" data-hoffset="" data-y="center" data-voffset="" data-width="['none','none','none','none']" data-height="['none','none','none','none']" data-type="image" data-responsive_offset="on" data-frames='[{"from":"opacity:0;","speed":300,"to":"o:1;","delay":300,"ease":"Linear.easeNone"},{"delay":"wait","speed":300,"to":"opacity:0;","ease":"nothing"}]' data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]">
                        <img src="http://placehold.it/870x407.jpg" alt="" data-ww="870px" data-hh="407px" width="870" height="407" data-no-retina>
                    </div>
                    <!-- LAYER NR. 2 -->
                    <div class="tp-caption black tp-resizeme" id="slide-1-layer-2" data-x="center" data-hoffset="-205" data-y="70" data-width="['auto']" data-height="['auto']" data-type="text" data-responsive_offset="on" data-frames='[{"from":"z:0;rX:0;rY:0;rZ:0;sX:0.9;sY:0.9;skX:0;skY:0;opacity:0;","speed":1000,"to":"o:1;","delay":600,"split":"chars","splitdelay":0.1,"ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"to":"opacity:0;","ease":"nothing"}]' data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]">BERETTA </div>
                    <!-- LAYER NR. 3 -->
                    <div class="tp-caption black tp-resizeme" id="slide-1-layer-3" data-x="center" data-hoffset="-205" data-y="145" data-width="['auto']" data-height="['auto']" data-visibility="['on','on','on','off']" data-type="text" data-responsive_offset="on" data-frames='[{"from":"y:-50px;opacity:0;","speed":700,"to":"o:1;","delay":1300,"ease":"Power2.easeInOut"},{"delay":"wait","speed":300,"to":"opacity:0;","ease":"nothing"}]' data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]">MODEL 92FS INOX </div>
                    <!-- LAYER NR. 4 -->
                    <div class="tp-caption black tp-resizeme" id="slide-1-layer-4" data-x="center" data-hoffset="-205" data-y="190" data-width="['auto']" data-height="['auto']" data-type="text" data-responsive_offset="on" data-frames='[{"from":"z:0;rX:0;rY:0;rZ:0;sX:0.9;sY:0.9;skX:0;skY:0;opacity:0;","speed":700,"to":"o:1;","delay":1700,"ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"to":"opacity:0;","ease":"nothing"}]' data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]">$370.00 </div>
                    <!-- LAYER NR. 5 -->
                    <div class="tp-caption black tp-resizeme" id="slide-1-layer-5" data-x="center" data-hoffset="-205" data-y="260" data-width="['auto']" data-height="['auto']" data-visibility="['on','on','off','off']" data-type="text" data-actions='[{"event":"click","action":"simplelink","target":"_self","url":"shop.html","delay":""}]' data-responsive_offset="on" data-frames='[{"from":"opacity:0;","speed":700,"to":"o:1;","delay":"2100","ease":"Power2.easeInOut"},{"delay":"wait","speed":300,"to":"opacity:0;","ease":"nothing"},{"frame":"hover","speed":"300","ease":"Linear.easeNone","to":"o:1;rX:0;rY:0;rZ:0;z:0;","style":"c:rgba(255,255,255,1);bg:rgba(255,255,255,1);bw:2px 2px 2px 2px;color:#000;"}]' data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]" data-paddingright="[28,28,28,28]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[28,28,28,28]">shop now </div>
                </li>
               @endforeach
            </ul>
            <div class="tp-bannertimer tp-bottom"></div>
        </div>
    </div>
    <!-- END REVOLUTION SLIDER -->
</div>




{{-- <section class="slider_section mb-15">
    <div class="slider_area owl-carousel">
      @foreach($sliderImage  as $row)
        <div class="single_slider d-flex align-items-center" data-bgimg="{{asset('storage/sliders/'.$row->image)}}">
           <div class="container">
               <div class="row">
                   <div class="col-12">
                       <div class="slider_content">
                           <h1> The Frisco</h1>
                            <h2>Armchair</h2>
                            <p>An elegant selection of chairs combining comfort & practicality. Providing the perfect solution for large & small scale exhibition</p>
                            <a class="button" href="shop.html">shop Now <i class="fa fa-angle-double-right"></i></a>
                        </div>
                   </div>
               </div>
           </div>
        </div>
      @endforeach
    </div>
</section> --}}