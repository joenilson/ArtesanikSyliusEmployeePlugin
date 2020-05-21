<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200410023400 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'ADD TABLE sylius_employee_limit';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE sylius_employee_limit ('
                . 'id INT AUTO_INCREMENT NOT NULL, '
                . 'channel INT DEFAULT NULL, '
                . 'description VARCHAR(120) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, '
                . 'limittype VARCHAR(32) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, '
                . 'limitvalue NUMERIC(18, 4) DEFAULT \'NULL\', '
                . 'periodicity VARCHAR(32) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, '
                . 'isactive TINYINT(1) NOT NULL, '
                . 'createdat DATETIME NOT NULL, '
                . 'modifiedat DATETIME DEFAULT \'NULL\', '
                . 'INDEX IDX_4BA14FE2A2F98E47 (channel), '
                . 'PRIMARY KEY(id)) '
                . 'DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
    }
    
    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE sylius_employee_limit');
    }
}
