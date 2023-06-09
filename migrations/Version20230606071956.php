<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230606071956 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appareil_mesure_electrique (id INT AUTO_INCREMENT NOT NULL, parametre_id INT DEFAULT NULL, appareil_id INT DEFAULT NULL, INDEX IDX_6456520D6358FF62 (parametre_id), INDEX IDX_6456520DBF6A0032 (appareil_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE appareil_mesure_electrique ADD CONSTRAINT FK_6456520D6358FF62 FOREIGN KEY (parametre_id) REFERENCES parametre (id)');
        $this->addSql('ALTER TABLE appareil_mesure_electrique ADD CONSTRAINT FK_6456520DBF6A0032 FOREIGN KEY (appareil_id) REFERENCES appareil (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appareil_mesure_electrique DROP FOREIGN KEY FK_6456520D6358FF62');
        $this->addSql('ALTER TABLE appareil_mesure_electrique DROP FOREIGN KEY FK_6456520DBF6A0032');
        $this->addSql('DROP TABLE appareil_mesure_electrique');
    }
}
