<div style="background: #333333; color: #eeeeee;">
        <div class="container" style="padding: 30px 0;">
            <a class="footer" target="_new" href="https://aaronjay.com">Aaron Jay Lev</a> &copy <?php echo date("Y"); ?> 
            - Visit my <a class="footer" target="_new" href="https://linkedin.com/in/aaronjay">LinkedIn</a> Page
        </div>
    </div>

	<!-- Import React, React-Dom and Babel libraries from modules -->
    <script src="https://unpkg.com/react@16/umd/react.development.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@16/umd/react-dom.development.js" crossorigin></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<?php
    if (isset($footerScripts)) {
        echo $footerScripts;
    }
?>
</body>
</html>