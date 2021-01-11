<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201217195255 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commodity_business (commodity_id INT NOT NULL, business_id INT NOT NULL, INDEX IDX_744F2BCEB4ACC212 (commodity_id), INDEX IDX_744F2BCEA89DB457 (business_id), PRIMARY KEY(commodity_id, business_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commodity_business ADD CONSTRAINT FK_744F2BCEB4ACC212 FOREIGN KEY (commodity_id) REFERENCES commodity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commodity_business ADD CONSTRAINT FK_744F2BCEA89DB457 FOREIGN KEY (business_id) REFERENCES business (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commodity DROP FOREIGN KEY FK_5E8D2F74A89DB457');
        $this->addSql('DROP INDEX IDX_5E8D2F74A89DB457 ON commodity');
        $this->addSql('ALTER TABLE commodity DROP business_id, CHANGE title title VARCHAR(50) DEFAULT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE price price FLOAT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE commodity_business');
        $this->addSql('ALTER TABLE commodity ADD business_id INT NOT NULL, CHANGE title title VARCHAR(60) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE price price INT NOT NULL');
        $this->addSql('ALTER TABLE commodity ADD CONSTRAINT FK_5E8D2F74A89DB457 FOREIGN KEY (business_id) REFERENCES business (id)');
        $this->addSql('CREATE INDEX IDX_5E8D2F74A89DB457 ON commodity (business_id)');
    }
}
