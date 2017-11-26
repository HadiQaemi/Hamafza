
<style>
    ul.nav-wizard {
        background-color: #f9f9f9;
        border: 1px solid #d4d4d4;
        -webkit-border-radius: 6px;
        -moz-border-radius: 6px;
        border-radius: 6px;
        *zoom: 1;
        position: relative;
        overflow: hidden;
    }
    ul.nav-wizard:before {
        display: block;
        position: absolute;
        right: 0px;
        left: 0px;
        top: 46px;
        height: 47px;
        border-top: 1px solid #d4d4d4;
        border-bottom: 1px solid #d4d4d4;
        z-index: 11;
        content: " ";
    }
    ul.nav-wizard:after {
        display: block;
        position: absolute;
        right: 0px;
        left: 0px;
        top: 138px;
        height: 47px;
        border-top: 1px solid #d4d4d4;
        border-bottom: 1px solid #d4d4d4;
        z-index: 11;
        content: " ";
    }
    ul.nav-wizard li {
        position: relative;
        float: right;
        height: 46px;
        display: inline-block;
        text-align: middle;
        padding: 0 20px 0 30px;
        margin: 0;
        font-size: 16px;
        line-height: 46px;
        width: 47%;
        text-align: center;
    }
    ul.nav-wizard li a {
        color: #468847;
        padding: 0;
    }
    ul.nav-wizard li a:hover {
        background-color: transparent;
    }
    ul.nav-wizard li:before {
        position: absolute;
        display: block;
        border: 24px solid transparent;
        border-right: 16px solid #d4d4d4;
        border-left: 0;
        top: -1px;
        z-index: 10;
        content: '';
        left: -16px;
    }
    ul.nav-wizard li:after {
        position: absolute;
        display: block;
        border: 24px solid transparent;
        border-right: 16px solid #f9f9f9;
        border-left: 0;
        top: -1px;
        z-index: 10;
        content: '';
        left: -15px;
    }
    ul.nav-wizard li.active {
        color: #3a87ad;
        background: #d9edf7;
    }
    ul.nav-wizard li.active:after {
        border-right: 16px solid #d9edf7;
    }
    ul.nav-wizard li.active a,
    ul.nav-wizard li.active a:active,
    ul.nav-wizard li.active a:visited,
    ul.nav-wizard li.active a:focus {
        color: #3a87ad;
        background: #d9edf7;
    }
    ul.nav-wizard .active ~ li {
        color: #999999;
        background: #ededed;
    }
    ul.nav-wizard .active ~ li:after {
        border-right: 16px solid #ededed;
    }
    ul.nav-wizard .active ~ li a,
    ul.nav-wizard .active ~ li a:active,
    ul.nav-wizard .active ~ li a:visited,
    ul.nav-wizard .active ~ li a:focus {
        color: #999999;
        background: #ededed;
    }
    ul.nav-wizard.nav-wizard-backnav li:hover {
        color: #468847;
        background: #f6fbfd;
    }
    ul.nav-wizard.nav-wizard-backnav li:hover:after {
        border-right: 16px solid #f6fbfd;
    }
    ul.nav-wizard.nav-wizard-backnav li:hover a,
    ul.nav-wizard.nav-wizard-backnav li:hover a:active,
    ul.nav-wizard.nav-wizard-backnav li:hover a:visited,
    ul.nav-wizard.nav-wizard-backnav li:hover a:focus {
        color: #468847;
        background: #f6fbfd;
    }
    ul.nav-wizard.nav-wizard-backnav .active ~ li {
        color: #999999;
        background: #ededed;
    }
    ul.nav-wizard.nav-wizard-backnav .active ~ li:after {
        border-right: 16px solid #ededed;
    }
    ul.nav-wizard.nav-wizard-backnav .active ~ li a,
    ul.nav-wizard.nav-wizard-backnav .active ~ li a:active,
    ul.nav-wizard.nav-wizard-backnav .active ~ li a:visited,
    ul.nav-wizard.nav-wizard-backnav .active ~ li a:focus {
        color: #999999;
        background: #ededed;
    }

</style>