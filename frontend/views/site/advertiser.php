<?php
/**
 * Created by PhpStorm.
 * User: angelus
 * Date: 23.02.2016
 * Time: 5:42
 */
$this->title = 'Xclusivo - '.Yii::t('app', 'advertiser');
?>
<div id="content">
    <div class="cont-in">
        <div class="sidebar">
            <div class="side-filter">
                <div class="filter-title"><?=Yii::t('app', 'Precise search');?></div>
                <div class="filter-cont">
                    <div class="checks checks-cols">
                        <div class="check"><input type="checkbox" checked=""/><label><?=Yii::t('app', 'Girls');?></label></div>
                        <div class="check"><input type="checkbox"/><label><?=Yii::t('app', 'Gays');?></label></div>
                        <div class="check"><input type="checkbox"/><label><?=Yii::t('app', 'Boys');?></label></div>
                        <div class="check"><input type="checkbox"/><label><?=Yii::t('app', 'Agencies');?></label></div>
                        <div class="check"><input type="checkbox"/><label><?=Yii::t('app', 'Couples');?></label></div>
                        <div class="check"><input type="checkbox"/><label><?=Yii::t('app', 'Duos');?></label></div>
                        <div class="check"><input type="checkbox"/><label><?=Yii::t('app', 'Tv-Ts');?></label></div>
                    </div>
                    <div class="filter-block">
                        <div class="filter-label filter-opener"><?=Yii::t('app', 'Price');?></div>
                        <div class="filter-drop"></div>
                    </div>
                    <div class="filter-block">
                        <a class="filter-label filter-date fancy" href="#pop-clnd"><?=Yii::t('app', 'Date');?></a>
                    </div>
                    <div class="filter-block">
                        <div class="filter-label"><?=Yii::t('app', 'Age');?>
                            <div class="range-row"><input type="text" class="t-inp"/><span>&mdash;</span><input type="text" class="t-inp"/><span> <?=Yii::t('app', 'y.o.');?>'</span></div>
                        </div>
                    </div>
                    <div class="filter-block active">
                        <div class="filter-label filter-opener"><?=Yii::t('app', 'Appearance');?></div>
                        <div class="filter-drop">
                            <div class="f-row">
                                <label><?=Yii::t('app', 'Height');?></label><div class="range-row"><input type="text" class="t-inp"/><span>&mdash;</span><input type="text" class="t-inp"/><span><?=Yii::t('app', 'cm');?></span></div>
                            </div>
                            <div class="f-row">
                                <label><?=Yii::t('app', 'Weight');?></label><div class="range-row"><input type="text" class="t-inp"/><span>&mdash;</span><input type="text" class="t-inp"/><span><?=Yii::t('app', 'kg');?></span></div>
                            </div>
                            <div class="f-row">
                                <label><?=Yii::t('app', 'Hair color');?></label>
                                <div class="colors">
                                    <span class="color color1"></span>
                                    <span class="color color2"></span>
                                    <span class="color color3"></span>
                                    <span class="color color4"></span>
                                    <span class="color color5"></span>
                                </div>
                            </div>
                            <div class="f-row">
                                <label><?=Yii::t('app', 'Eye color');?></label>
                                <div class="colors">
                                    <span class="color color6"></span>
                                    <span class="color color7"></span>
                                    <span class="color color8"></span>
                                    <span class="color color9"></span>
                                </div>
                            </div>
                            <div class="f-row">
                                <label>Skin color</label>
                                <div class="colors">
                                    <span class="color color10"></span>
                                    <span class="color color11"></span>
                                    <span class="color color12"></span>
                                    <span class="color color13"></span>
                                </div>
                            </div>
                            <div class="f-row">
                                <div class="check"><input type="checkbox"/><label><?=Yii::t('app', 'Silicone breasts');?></label></div>
                            </div>
                        </div>
                    </div>
                    <div class="filter-block">
                        <div class="filter-label filter-opener"><?=Yii::t('app', 'Nationality');?></div>
                        <div class="filter-drop"></div>
                    </div>
                    <div class="filter-block">
                        <div class="filter-label filter-opener"><?=Yii::t('app', 'Service offering');?></div>
                        <div class="filter-drop"></div>
                    </div>
                    <div class="filter-block">
                        <div class="filter-label filter-opener"><?=Yii::t('app', 'Service receiving');?></div>
                        <div class="filter-drop"></div>
                    </div>
                    <div class="filter-submit">
                        <a href="#" class="link-cancel"><?=Yii::t('app', 'Reset');?></a>
                        <a href="#" class="btn btn-gray"><?=Yii::t('app', 'Filter');?></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="user-cont girl-view">
            <div class="user-col">
                <div class="girl-profile">
                    <div class="fields-top">
                        <div class="field-name">Marianna</div>
                        <a href="#pop-clnd" class="link-datepicker fancy"><span>Calendar</span></a>
                        <a href="#pop-book" class="btn fancy">Book</a>
                    </div>
                    <div class="field-short">“I am a hot blonde;) willing to make your dreams come true. In your place or mine!”</div>
                    <div class="prof-cols">
                        <div class="col-photos">
                            <div class="main-photo">
                                <img src="/images/img17.jpg" alt=""/>
                            </div>
                            <div class="thumbs">
                                <div class="thumb"><img src="/images/img12.jpg" alt=""/></div>
                                <div class="thumb"><img src="/images/img13.jpg" alt=""/></div>
                                <div class="thumb"><img src="/images/img14.jpg" alt=""/></div>
                                <div class="thumb"><img src="/images/img15.jpg" alt=""/></div>
                                <div class="thumb"><img src="/images/img16.jpg" alt=""/></div>
                            </div>
                        </div>
                        <div class="col-sett">
                            <div class="field-place green">Available now in <a href="#">Oslo</a></div>
                            <div class="filter-block">
                                <div class="filter-label">Price
                                    <div class="filter-value">25 €/h</div>
                                </div>
                            </div>
                            <div class="filter-block">
                                <div class="filter-label filter-opener">Extra cost</div>
                                <div class="filter-drop"></div>
                            </div>
                            <div class="filter-block">
                                <div class="filter-label">Age
                                    <div class="filter-value">25 y.o.</div>
                                </div>
                            </div>
                            <div class="filter-block active">
                                <div class="filter-label filter-opener">Appearance</div>
                                <div class="filter-drop">
                                    <div class="f-row">
                                        <label>Height</label>
                                        <div class="filter-value">167 cm</div>
                                    </div>
                                    <div class="f-row">
                                        <label>Weight</label>
                                        <div class="filter-value">55 kg</div>
                                    </div>
                                    <div class="f-row">
                                        <label>Hair color</label>
                                        <div class="filter-value">
                                            <span class="color color1"></span>Blonde
                                        </div>
                                    </div>
                                    <div class="f-row">
                                        <label>Eye color</label>
                                        <div class="filter-value">
                                            <span class="color color6"></span>Gray
                                        </div>
                                    </div>
                                    <div class="f-row">
                                        <label>Skin color</label>
                                        <div class="filter-value">
                                            <span class="color color10"></span>Light
                                        </div>
                                    </div>
                                    <div class="f-row">
                                        <div class="check"><input type="checkbox"/><label>Silicone breasts</label></div>
                                    </div>
                                </div>
                            </div>
                            <div class="filter-block">
                                <div class="filter-label">Nationality
                                    <div class="filter-value">Caucasian</div>
                                </div>
                            </div>
                            <div class="filter-block">
                                <div class="filter-label filter-opener">Services offering</div>
                                <div class="filter-drop white">
                                    <div class="tags">
                                        <a href="#">69</a> <a href="#">Advanced</a> <a href="#">American</a> <a href="#">Cum in mouth</a>
                                        <a href="#">Classic Cocktail</a> <a href="#">COB</a> <a href="#">Cum  On Face</a> <a href="#">Domination</a>
                                    </div>
                                </div>
                            </div>
                            <div class="filter-block">
                                <div class="filter-label filter-opener">Services receiving</div>
                                <div class="filter-drop white">
                                    <div class="tags">
                                        <a href="#">69</a> <a href="#">Advanced</a> <a href="#">American</a> <a href="#">Cum in mouth</a>
                                        <a href="#">Classic Cocktail</a> <a href="#">COB</a> <a href="#">Cum  On Face</a> <a href="#">Couples</a> <a href="#">Danish /Missionary Position</a>
                                        <a href="#">Deep Throat</a> <a href="#">Dominance: Money</a> <a href="#">Dominance: Slave</a> <a href="#">Dutch/Foot</a> <a href="#">Sex</a>
                                        <a href="#">Erotic massage</a> <a href="#">Body massage</a> <a href="#">Escortdate/sexdate</a> <a href="#">Fetish-fashion</a>
                                        <a href="#">Fingersex</a> <a href="#">French</a> <a href="#">Girl Friend Experience  (GFE)</a> <a href="#">Greek (anal sex)</a> <a href="#">Jeans</a> <a href="#">Domination</a>
                                    </div>
                                </div>
                            </div>
                            <div class="filter-block">
                                <div class="filter-label filter-opener">Reviews<sup>(12)</sup></div>
                                <div class="filter-drop"></div>
                            </div>

                        </div>
                    </div>
                    <div class="field-desc">
                        <p>I am a hot blonde;) willing to make your dreams come true. In your place or mine! I am very intelligent and well-mannered, but also very open-minded and always ready for new experience, full of fantasy. I will be the perfect companion for any occasion, even for social or sport events, sightseeng tours, business trips, exotic vacations or just an exciting and passionate night in your or my place. You will never forget a minute with me! Iím available for incall and outcall </p>
                    </div>
                    <div class="sett-subm">
                        <a href="#pop-book" class="btn fancy">Book</a>
                        <a href="#pop-chat" class="link-chat f-right fancy">Start chat</a>
                        <a href="#" class="link-spam">Report spam</a>
                    </div>
                </div>
            </div>


        </div>
        <div class="fav-col fav-col2">
            <h2>Favorite Profiles<sup>(29)</sup></h2>
            <div class="fav-slider2">
                <div class="girl offline gfav"><a href="#" class="cover-link"></a>
                    <div class="girl-img"><img src="/images/img1.jpg" alt=""/><a href="#" class="fav on"></a></div>
                    <div class="girl-cont">
                        <div class="girl-name">Anna, 25</div>
                        <div class="girl-price"><b>25</b> €/h</div>
                        <div class="girl-txt">I am a hot blonde;) willing to make your dreams come true.</div>
                    </div>

                </div>
                <div class="girl offline gfav"><a href="#" class="cover-link"></a>
                    <div class="girl-img"><img src="/images/img2.jpg" alt=""/><a href="#" class="fav on"></a></div>
                    <div class="girl-cont">
                        <div class="girl-name">Anna, 25</div>
                        <div class="girl-price"><b>25</b> €/h</div>
                        <div class="girl-txt">I am a hot blonde;) willing to make your dreams come true.</div>
                    </div>
                </div>
                <div class="girl offline gfav"><a href="#" class="cover-link"></a>
                    <div class="girl-img"><img src="/images/img3.jpg" alt=""/><a href="#" class="fav on"></a></div>
                    <div class="girl-cont">
                        <div class="girl-name">Anna, 25</div>
                        <div class="girl-price"><b>25</b> €/h</div>
                        <div class="girl-txt">I am a hot blonde;) willing to make your dreams come true.</div>
                    </div>
                </div>
                <div class="girl gfav"><a href="#" class="cover-link"></a>
                    <div class="girl-img"><img src="/images/img4.jpg" alt=""/><a href="#" class="fav on"></a></div>
                    <div class="girl-cont">
                        <div class="girl-name">Anna, 25</div>
                        <div class="girl-price"><b>25</b> €/h</div>
                        <div class="girl-txt">I am a hot blonde;) willing to make your dreams come true.</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div style="display:none;">
    <div class="pop-up" id="pop-clnd">
        <div class="col-clnd">
            <div class="pop-title title-date">Marianna's calendar</div>
            <div class="panes">
                <div class="pane" id="pane1">
                    <table class="table-month">
                        <tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr>
                        <tr><td colspan="7" class="trline"><i></i></td></tr>
                        <tr><td></td><td></td><td><a href="#">1</a></td><td><a href="#">2</a></td><td><a href="#">3</a></td><td><a href="#">4</a></td><td><a href="#">5</a></td></tr>
                        <tr><td><a href="#">6</a></td><td><a href="#">7</a></td><td><a href="#">8</a></td><td><a href="#">9</a></td><td><a href="#">10</a></td><td><a href="#">11</a></td><td><a href="#">12</a></td></tr>
                        <tr><td><a href="#">13</a></td><td><a href="#">14</a></td><td><a href="#" class="free">15</a></td><td><a href="#" class="free">16</a></td><td><a href="#" class="free">17</a></td><td><a href="#" class="free">18</a></td><td><a href="#" class="busy">19</a></td></tr>
                        <tr><td><a href="#" class="busy">20</a></td><td><a href="#" class="free">21</a></td><td><a href="#" class="busy">22</a></td><td><a href="#" class="book">23</a></td><td><a href="#" class="book">24</a></td><td><a href="#" class="book">25</a></td><td><a href="#" class="busy">26</a></td></tr>
                        <tr><td><a href="#" class="free">27</a></td><td><a href="#" class="free">28</a></td><td><a href="#" class="free">29</a></td><td><a href="#" class="free">30</a></td><td><a href="#" class="free">31</a></td><td></td><td></td></tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-work">
            <div class="pop-title title-time">Working hours</div>
            <table class="table-time">
                <tr><td>Sunday</td><td>09:00 - 18:00</td></tr>
                <tr><td>Monday</td><td>09:00 - 18:00</td></tr>
                <tr><td>Tuesday</td><td>09:00 - 18:00</td></tr>
                <tr><td>Wednesday</td><td>09:00 - 18:00</td></tr>
                <tr><td>Thursday</td><td>09:00 - 18:00</td></tr>
                <tr><td>Friday</td><td>21:00 - 06:00</td></tr>
                <tr><td>Saturday</td><td>21:00 - 06:00</td></tr>
            </table>
        </div>
        <a href="#" class="btn btn-book">Book</a>
    </div>

    <div class="pop-up" id="pop-book">
        <div class="pop-title title-book">Booking time with Marianna</div>
        <div class="mess-form">
            <div class="form-row">
                <label>From</label>
                <input type="text" class="t-inp t-inp1" value="23 Dec 2015"/>
                <input type="text" class="t-inp t-inp2" value="22:00"/>
            </div>
            <div class="form-row">
                <label>To</label>
                <input type="text" class="t-inp t-inp1" value="25 Dec 2015"/>
                <input type="text" class="t-inp t-inp2" value="22:00"/>
            </div>
        </div>
        <div class="mess-submit">
            <a href="#" class="link-back">Back</a>
            <input type="submit" value="Proceed to Payment" class="btn"/>
        </div>
    </div>
</div>

<div style="position:absolute;left:0;top:-9999px;">
    <div class="pop-up pop-chat" id="pop-chat">
        <div class="pop-title">Chat to Marianna</div>
        <div class="revs scroll">
            <div class="rev">
                <div class="rev-name"><a href="#">Marianna, 25</a></div>
                <div class="rev-txt">A very hot blonde;) willing to make your dreams come true. IShe's very intelligent and well-mannered.</div>
            </div>
            <div class="rev">
                <div class="rev-name"><a href="#">Alexander</a></div>
                <div class="rev-txt">True. Okey Marianna i help you. Come to me.</div>
            </div>
            <div class="rev">
                <div class="rev-name"><a href="#">Marianna, 25</a></div>
                <div class="rev-txt">A very hot blonde;) willing to make your dreams come true. IShe's very intelligent and well-mannered.</div>
            </div>
            <div class="rev">
                <div class="rev-name"><a href="#">Marianna, 25</a></div>
                <div class="rev-txt">A very hot blonde;) willing to make your dreams come true. IShe's very intelligent and well-mannered.</div>
            </div>
            <div class="rev">
                <div class="rev-name"><a href="#">Alexander</a></div>
                <div class="rev-txt">True. Okey Marianna i help you. Come to me.</div>
            </div>
            <div class="rev">
                <div class="rev-name"><a href="#">Marianna, 25</a></div>
                <div class="rev-txt">A very hot blonde;) willing to make your dreams come true. IShe's very intelligent and well-mannered.</div>
            </div>
        </div>

        <div class="add-rev">
            <textarea></textarea>
            <input type="submit" class="btn" value="Submit"/>
        </div>
    </div>
</div>
