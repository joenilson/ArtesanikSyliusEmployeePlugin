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
        return 'ALTERING TABLE sylius_customer';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE sylius_customer ADD employeeid VARCHAR(32) NULL');
        $this->addSql('ALTER TABLE sylius_customer ADD position VARCHAR(120) NULL');
        $this->addSql('ALTER TABLE sylius_customer ADD department VARCHAR(120) NULL');
        $this->addSql('ALTER TABLE sylius_customer ADD office VARCHAR(120) NULL');
        $this->addSql('ALTER TABLE sylius_customer ADD company VARCHAR(120) NULL');
        $this->addSql('ALTER TABLE sylius_customer ADD limitpurchase TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE sylius_customer ADD limitid INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sylius_customer ADD limitexcluded TINYINT(1) DEFAULT \'0\' NOT NULL');
    }
    
    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE sylius_customer DROP employeeid');
        $this->addSql('ALTER TABLE sylius_customer DROP position');
        $this->addSql('ALTER TABLE sylius_customer DROP department');
        $this->addSql('ALTER TABLE sylius_customer DROP office');
        $this->addSql('ALTER TABLE sylius_customer DROP company');
        $this->addSql('ALTER TABLE sylius_customer DROP limitpurchase');
        $this->addSql('ALTER TABLE sylius_customer DROP limitid');
        $this->addSql('ALTER TABLE sylius_customer DROP limitexcluded');
    }
}
