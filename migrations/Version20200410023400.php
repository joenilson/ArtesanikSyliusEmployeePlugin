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
        // this up() migration is auto-generated, please modify it to your needs
	$this->addSql('ALTER TABLE sylius_customer ADD employeeid VARCHAR(32) NULL');
	$this->addSql('ALTER TABLE sylius_customer ADD position VARCHAR(120) NULL');
	$this->addSql('ALTER TABLE sylius_customer ADD office VARCHAR(120) NULL');
	$this->addSql('ALTER TABLE sylius_customer ADD company VARCHAR(120) NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
	$this->addSql('ALTER TABLE sylius_customer DROP employeeid');
	$this->addSql('ALTER TABLE sylius_customer DROP position');
	$this->addSql('ALTER TABLE sylius_customer DROP office');
	$this->addSql('ALTER TABLE sylius_customer DROP company');
    }
}
