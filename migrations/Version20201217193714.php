<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201217193714 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commodity (id INT AUTO_INCREMENT NOT NULL, business_id INT NOT NULL, title VARCHAR(60) NOT NULL, description LONGTEXT NOT NULL, image VARCHAR(100) DEFAULT NULL, price FLOAT NOT NULL, remaining INT NOT NULL, INDEX IDX_5E8D2F74A89DB457 (business_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commodity ADD CONSTRAINT FK_5E8D2F74A89DB457 FOREIGN KEY (business_id) REFERENCES business (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commodity DROP FOREIGN KEY FK_5E8D2F74A89DB457');
        $this->addSql('DROP TABLE commodity');
    }
}
