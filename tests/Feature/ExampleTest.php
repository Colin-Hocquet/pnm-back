<?php

it('has welcome page')->get('/welcome')->assertStatus(200);
