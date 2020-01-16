<?php

Route::post('/slack', 'SlackController@action')/*->middleware('log_after')*/;
