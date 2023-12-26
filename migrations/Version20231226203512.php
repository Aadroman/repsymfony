<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231226203512 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chanson_artiste (chanson_id INT NOT NULL, artiste_id INT NOT NULL, INDEX IDX_77F23BCD2D0460C5 (chanson_id), INDEX IDX_77F23BCD21D25844 (artiste_id), PRIMARY KEY(chanson_id, artiste_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chanson_artiste ADD CONSTRAINT FK_77F23BCD2D0460C5 FOREIGN KEY (chanson_id) REFERENCES chanson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE chanson_artiste ADD CONSTRAINT FK_77F23BCD21D25844 FOREIGN KEY (artiste_id) REFERENCES artiste (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chanson_artiste DROP FOREIGN KEY FK_77F23BCD2D0460C5');
        $this->addSql('ALTER TABLE chanson_artiste DROP FOREIGN KEY FK_77F23BCD21D25844');
        $this->addSql('DROP TABLE chanson_artiste');
    }
}
