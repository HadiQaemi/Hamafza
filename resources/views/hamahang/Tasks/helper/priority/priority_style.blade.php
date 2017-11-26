<style>
    .dragged {
        position: absolute;
    }
    .task_items {
        width: 100%;
        height: 200px;
        overflow-y: scroll;
        overflow-x: hidden;
        border: 1px solid #ececec;
        direction: ltr;

    }

    .task_items li {
        position: relative;
        margin: 2px 5px;
        z-index: 50;
        width: calc(100% - 10px);
        cursor: move;
    }

    .droppable {
        background-color: #eee;
    }

    .over {
        border: 2px dashed #000000;
    }

    .draggable {
        border: 1px solid #e0e0e0;
        background-color: #e0f7fa;
    }

    .draggable .respite_number {
        right: 5px;
        color: #fff;
        width: 32px;
        height: 32px;
        line-height: 32px;
        text-align: center;
        position: absolute;
        border-radius: 32px;
        /*background: red;*/
        direction: ltr;
        top: 1px;
        /*padding: 2px ;*/
    }

    .bg_red {
        background: #ff6162;
    }

    .bg_green {
        background: #00AD00;
    }

    .draggable .task_title {
        position: relative;
        margin-right: 45px;
        margin-left: 80px;
    }

    .draggable .task_title h5 a {
        font-size: 12px;
    }

    .draggable .state {
        position: absolute;
        left: 5px;
        top: 5px;
        width: 25px;
        text-align: center;
    }

    .draggable .referrer {
        position: absolute;
        left: 40px;
        top: 5px;
        width: 25px;
        text-align: center;
    }
    .priority_state_list {
        /*position: relative;*/
    }
    .priority_state_list .state_title {
        font-size: 14px;
        text-align: center;
        font-weight: bold;
    }
</style>