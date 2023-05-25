<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230525075227 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lappareil DROP FOREIGN KEY FK_7C16D96D35F8E4A2');
        $this->addSql('ALTER TABLE lappareil DROP FOREIGN KEY FK_7C16D96DBF6A0032');
        $this->addSql('DROP TABLE lappareil');
        $this->addSql('ALTER TABLE appareil_mesure ADD parametre_id INT DEFAULT NULL, ADD appareil_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE appareil_mesure ADD CONSTRAINT FK_123A82CA6358FF62 FOREIGN KEY (parametre_id) REFERENCES parametre (id)');
        $this->addSql('ALTER TABLE appareil_mesure ADD CONSTRAINT FK_123A82CABF6A0032 FOREIGN KEY (appareil_id) REFERENCES appareil (id)');
        $this->addSql('CREATE INDEX IDX_123A82CA6358FF62 ON appareil_mesure (parametre_id)');
        $this->addSql('CREATE INDEX IDX_123A82CABF6A0032 ON appareil_mesure (appareil_id)');
        $this->addSql('ALTER TABLE parametre DROP FOREIGN KEY FK_ACC79041F5799F59');
        $this->addSql('DROP INDEX UNIQ_ACC79041F5799F59 ON parametre');
        $this->addSql('ALTER TABLE parametre DROP apparail_mesure_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lappareil (id INT AUTO_INCREMENT NOT NULL, appareil_id INT DEFAULT NULL, appareil_messure_id INT DEFAULT NULL, lig INT DEFAULT NULL, INDEX IDX_7C16D96D35F8E4A2 (appareil_messure_id), INDEX IDX_7C16D96DBF6A0032 (appareil_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE lappareil ADD CONSTRAINT FK_7C16D96D35F8E4A2 FOREIGN KEY (appareil_messure_id) REFERENCES appareil_mesure (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE lappareil ADD CONSTRAINT FK_7C16D96DBF6A0032 FOREIGN KEY (appareil_id) REFERENCES appareil (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE appareil_mesure DROP FOREIGN KEY FK_123A82CA6358FF62');
        $this->addSql('ALTER TABLE appareil_mesure DROP FOREIGN KEY FK_123A82CABF6A0032');
        $this->addSql('DROP INDEX IDX_123A82CA6358FF62 ON appareil_mesure');
        $this->addSql('DROP INDEX IDX_123A82CABF6A0032 ON appareil_mesure');
        $this->addSql('ALTER TABLE appareil_mesure DROP parametre_id, DROP appareil_id');
        $this->addSql('ALTER TABLE parametre ADD apparail_mesure_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parametre ADD CONSTRAINT FK_ACC79041F5799F59 FOREIGN KEY (apparail_mesure_id) REFERENCES appareil_mesure (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ACC79041F5799F59 ON parametre (apparail_mesure_id)');
    }
}
