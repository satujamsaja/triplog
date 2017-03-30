<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170330064202 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE trip (id INT AUTO_INCREMENT NOT NULL, trip_name VARCHAR(255) NOT NULL, trip_desc LONGTEXT DEFAULT NULL, is_public TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trip_category (id INT AUTO_INCREMENT NOT NULL, trip_cat_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trip_location (id INT AUTO_INCREMENT NOT NULL, trip_id INT DEFAULT NULL, trip_category_id INT DEFAULT NULL, trip_loc_name VARCHAR(255) NOT NULL, trip_loc_desc LONGTEXT DEFAULT NULL, trip_lat_lon VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_F6CFBADBA5BC2E0E (trip_id), INDEX IDX_F6CFBADBE6673A68 (trip_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trip_location ADD CONSTRAINT FK_F6CFBADBA5BC2E0E FOREIGN KEY (trip_id) REFERENCES trip (id)');
        $this->addSql('ALTER TABLE trip_location ADD CONSTRAINT FK_F6CFBADBE6673A68 FOREIGN KEY (trip_category_id) REFERENCES trip_category (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE trip_location DROP FOREIGN KEY FK_F6CFBADBA5BC2E0E');
        $this->addSql('ALTER TABLE trip_location DROP FOREIGN KEY FK_F6CFBADBE6673A68');
        $this->addSql('DROP TABLE trip');
        $this->addSql('DROP TABLE trip_category');
        $this->addSql('DROP TABLE trip_location');
    }
}
