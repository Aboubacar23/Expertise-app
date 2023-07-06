<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230706084616 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE synoptique (id INT AUTO_INCREMENT NOT NULL, parametre_id INT DEFAULT NULL, repere VARCHAR(255) DEFAULT NULL, INDEX IDX_619644A26358FF62 (parametre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE synoptique ADD CONSTRAINT FK_619644A26358FF62 FOREIGN KEY (parametre_id) REFERENCES parametre (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE synoptique DROP FOREIGN KEY FK_619644A26358FF62');
        $this->addSql('DROP TABLE synoptique');
    }
}
