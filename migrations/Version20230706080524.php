<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230706080524 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE roulement (id INT AUTO_INCREMENT NOT NULL, type_ca VARCHAR(255) DEFAULT NULL, type_coa VARCHAR(255) DEFAULT NULL, graisse_ca VARCHAR(255) DEFAULT NULL, graisse_coa VARCHAR(255) DEFAULT NULL, etat TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parametre ADD roulement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parametre ADD CONSTRAINT FK_ACC79041ABB37840 FOREIGN KEY (roulement_id) REFERENCES roulement (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ACC79041ABB37840 ON parametre (roulement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parametre DROP FOREIGN KEY FK_ACC79041ABB37840');
        $this->addSql('DROP TABLE roulement');
        $this->addSql('DROP INDEX UNIQ_ACC79041ABB37840 ON parametre');
        $this->addSql('ALTER TABLE parametre DROP roulement_id');
    }
}
