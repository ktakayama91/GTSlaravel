<?php
/*
* app/validators.php
*/

Validator::extend('alpha_spaces', function($attribute, $value)
{
	return preg_match('/^[\pL\s]+$/u', $value);
});

Validator::extend('alpha_num_dash', function($attribute, $value)
{
	return preg_match('/^[a-zA-Z0-9-_]+$/', $value);
});

Validator::extend('validator_marca', function($attribute, $value)
{
	return preg_match('/^[a-zA-Z0-9-&. ]+$/', $value);
});

Validator::extend('validator_grupo', function($attribute, $value)
{
	return preg_match('/^[a-zA-Z0-9- _]+$/', $value);
});

Validator::extend('validator_grupo_descripcion', function($attribute, $value)
{
	return preg_match('/^[a-zA-Z0-9- :_]+$/', $value);
});
