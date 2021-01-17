<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210117155404 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE command (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nb_command INT NOT NULL, total DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_8ECAEAD4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE command_commodity (command_id INT NOT NULL, commodity_id INT NOT NULL, INDEX IDX_D9BC607F33E1689A (command_id), INDEX IDX_D9BC607FB4ACC212 (commodity_id), PRIMARY KEY(command_id, commodity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE command_commodity ADD CONSTRAINT FK_D9BC607F33E1689A FOREIGN KEY (command_id) REFERENCES command (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE command_commodity ADD CONSTRAINT FK_D9BC607FB4ACC212 FOREIGN KEY (commodity_id) REFERENCES commodity (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE command_commodity DROP FOREIGN KEY FK_D9BC607F33E1689A');
        $this->addSql('DROP TABLE command');
        $this->addSql('DROP TABLE command_commodity');
    }
}
