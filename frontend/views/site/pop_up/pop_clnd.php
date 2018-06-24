<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 20.05.2016
 * Time: 17:22
 */
?>

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
    <?= $template['bookLINK'] ?>
</div>