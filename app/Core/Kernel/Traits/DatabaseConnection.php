<?php declare(strict_types = 1);

namespace App\Core\Kernel\Traits;

use App\Core\Database\{
    Builder as SQLiteDatabase, Eloquent
};

use Exception;

trait DatabaseConnection {

    private $database, $schema;

    /**
     * Holds the the current user database connection
     */
    private $schemaAccount;

    /**
     * Creates a motherboard connection which
     * will be used by all sqlite databases 
     */
    private function database() : void
    {
        $this->database = new SQLiteDatabase;
        $this->schema = $this->database::schema();

        $this->userAccountDatabase();
    }


    /**
     * A custom connection based on user account.
     * In order to keep things clean and tidy, we'll need to to create a dynamic SQLite database
     * connection, unique for each user account.
     * 
     * So, instead of sharing multiple database tables,
     * each user account will have attached an SQLite database where its data gets stored.
     */
    private function userAccountDatabase()
    {
        /**
         * Try connect to the user's sqlite database
         */
        try {

            /**
             * Create user account's database tables
             * Maybe is a better idea to be done by a task via Cronjobs
             */
            $this->createUserAccountDatabaseTables();

            // $currentUser = \App\Models\SystemUsers::where('email', 'hi@georgelemon.com');
            // $currentUser = $currentUser->get()->first()->toArray();
            // $account = \App\Models\UserAccountModel::on('account');

            // $account->update([
            //     'account_id' => $currentUser['id'],
            //     'email' => $currentUser['email'],
            //     'name' => $currentUser['name'],
            //     'picture' => serialize(json_encode(['src' => 'what/ever/image.jpg']))
            // ]);

        } catch (Exception $e) {
            // Mute the errors since it will throw an exception when the user gets logged out.
        }


        // var_dump($account->where('account_id', 8)->get()->toArray());
    }


    /**
     * A quick and dirty method that creates an sqlite database used
     * to store all user informations
     */
    private function createDefaultDatabaseTables() : void
    {

        // quick delete while in development
        // $schema->drop('users');
        // $schema->drop('registration');

        // die;

        if( ! $this->schema->hasTable('users') ) {

            $this->schema->create('users', function($table) {
                $table->id();
                $table->enum('status', ['inactive', 'active'])->default('inactive');
                $table->string('email')->unique();
                $table->string('name', 100);
                $table->text('password');
            });
        }

        if( ! $this->schema->hasTable('registration') ) {
            
            $this->schema->create('registration', function($table) {
                $table->id();
                $table->string('email')->unique();
                $table->text('confirmation_uri');
                $table->timestamp('created_at', 0);
            });
        }

    }

    /**
     * Creates the user account's SQLite database, including the file and tables
     */
    private function createUserAccountDatabaseTables()
    {

        // $capsule = Eloquent::getCapsule()->connection('account');

        /**
         * Get a schema builder instance for the Account database Connection.
         * @see Illuminate\Database\SQLiteConnection @ getSchemaBuilder()
         */
        $this->schemaBuilderConnection('account');

        if( ! $this->schemaAccount->hasTable('account') ) {
            
            $this->schemaAccount->create('account', function($table) {
                $table->bigInteger('account_id');
                $table->string('email')->unique();
                $table->string('name', 100);
                $table->string('picture');
            });

        }

    }

    private function schemaBuilderConnection(string $type)
    {
        $this->schemaAccount = $this->db()->connection($type)->getSchemaBuilder();
    }

    /**
     * {@inheritdoc}
     */
    private function db()
    {
        return $this->database;
    }

    /**
     * {@inheritdoc}
     */
    private function schema()
    {
        return $this->schema;
    }
}