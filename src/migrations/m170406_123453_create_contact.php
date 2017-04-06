<?php
use yii\db\Migration;

class m170406_123453_create_contact extends Migration
{
    protected $tableName = '{{%cm_contact}}';



    /**
     * Migration up action
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'email' => $this->string(255)->notNull(),
            'subject' => $this->string(255)->notNull(),
            'body' => $this->text()->notNull(),

            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created' => $this->dateTime()->notNull(),
            'updated' => $this->dateTime()->notNull(),
        ], $tableOptions);
    }

    /**
     * Migration down action
     */
    public function down()
    {
        $this->dropTable($this->tableName);
    }
}
