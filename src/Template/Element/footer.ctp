<footer class="footer-social-media navbar-fixed-bottom">
    <ul class="icons">
        <li class="icons-item">
            <a href="javascript:void(0)">
                <i class="fa fa-linkedin"></i>
            </a>
        </li>
        <li class="icons-item">
            <a href="javascript:void(0)">
                <i class="fa fa-twitter"></i>
            </a>
        </li>
        <li class="icons-item">
            <a href="javascript:void(0)">
                <i class="fa fa-facebook"></i>
            </a>
        </li>
    </ul>
</footer>

<?php
echo $this->append('css', $this->Html->css([
    'front/css/footer'
]));
echo $this->fetch('css');
?>