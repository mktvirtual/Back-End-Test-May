<?php
namespace Skp\Validation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\DatabasePresenceVerifier;
use Skp\Registry;
use Symfony\Component\Translation\Translator;
use Illuminate\Validation\Validator as IlluminateValidator;

class Validator
{

    const RULE_CREATE = 'create';
    const RULE_UPDATE = 'update';

    /**
     * @param array $data
     * @param array $rules
     * @param array $messages
     * @return IlluminateValidator
     */
    public static function make(array $data, array $rules, array $messages = [])
    {
        $config = Registry::get('Config');
        $validator = new IlluminateValidator(new Translator($config['app']['locale']), $data, $rules, $messages);

        $validator->setPresenceVerifier(new DatabasePresenceVerifier(Model::getConnectionResolver()));

        return $validator;
    }

} 