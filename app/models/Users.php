<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Confirmation;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\Uniqueness;

class Users extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $firstName;

    /**
     *
     * @var string
     */
    public $lastName;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $password;

    /**
     *
     * @var string
     */
    public $gender;

    /**
     *
     * @var string
     */
    public $details;

    /**
     *
     * @var string
     */
    public $hobby;

    /**
     *
     * @var string
     */
    public $fileName;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'users';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * Pre gen validator class
     * @param  boolean $createFlag flag to know if edit or create
     * @return Validator
     */
    public static function getValidator($createFlag = true)
    {
        $validation = new Validation();

        $validation->add(
            'firstName',
            new PresenceOf(
                array(
                    'message' => 'The first name is required'
                )
            )
        );

        $validation->add(
            'lastName',
            new PresenceOf(
                array(
                    'message' => 'The last name is required'
                )
            )
        );

        $validation->add(
            'gender',
            new PresenceOf(
                array(
                    'message' => 'The gender is required'
                )
            )
        );

        $validation->add(
            'gender',
            new InclusionIn(
                array(
                    'message' => 'The gender should be male or female',
                    'domain' => array('male', 'female')
                )
            )
        );

        $validation->add(
            'email',
            new PresenceOf(
                array(
                    'message' => 'The e-mail is required'
                )
            )
        );

        $validation->add(
            'email',
            new Email(
                array(
                    'message' => 'The e-mail is not valid'
                )
            )
        );

        if ($createFlag) {
            
            $validation->add(
                'email',
                new Uniqueness(
                    array(
                        'model' => 'Users',
                        'attribute' => 'email',
                        'message' => 'This email id is already taken.'
                    )
                )
            );

            $validation->add(
                'password',
                new PresenceOf(
                    array(
                        'message' => 'The password is required'
                    )
                )
            );

            $validation->add(
                'confirmPassword',
                new PresenceOf(
                    array(
                        'message' => 'The confirm password is required'
                    )
                )
            );

            $validation->add(
                'password',
                new Confirmation(
                    array(
                        'message' => 'Password and confirm password does not match',
                        'with' => 'confirmPassword'
                    )
                )
            );
        }

        $validation->add(
            'details',
            new PresenceOf(
                array(
                    'message' => 'The details are required'
                )
            )
        );

        $validation->add(
            'details',
            new InclusionIn(
                array(
                    'message' => 'The details should be either BE, ME, BCOM',
                    'domain' => array('BE', 'ME', 'BCOM')
                )
            )
        );

        $validation->add(
            'hobby',
            new PresenceOf(
                array(
                    'message' => 'The hobby is required'
                )
            )
        );

        return $validation;
    }
}
